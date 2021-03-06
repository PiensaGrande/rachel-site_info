<?php namespace pg_site_info; ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] .  "/admin/common.php"); ?>
<?php require_once(dirname(__FILE__) . "/pg-common.php"); ?>
<?php
include(dirname(__FILE__) . "/template.php");
$currlang = getlang();
$site_info_file = $_SERVER["DOCUMENT_ROOT"] . "/site_info.json";
// For these to affect apache, the IncludeOptional directives have to be set in /etc/apache2/apache2.conf.
// Set first one at the top of the file so the variable is usable throughout, set the second after the other logFormats.
// IncludeOptional /var/www/admin/.apache-*-include.conf
// IncludeOptional /var/www/admin/.apache-*-logFormats.conf
$apache_include_file = $_SERVER["DOCUMENT_ROOT"] . "/admin/.apache-{$templ['dirname']}-include.conf";
$apache_logFormats_file = $_SERVER["DOCUMENT_ROOT"] . "/admin/.apache-{$templ['dirname']}-logFormats.conf";

$location_type_map = array($templ["si-unknown"]=>"-1", $templ["si-rural"]=>"1", $templ["si-urban"]=>"10");
$funding_type_map = array($templ["si-unknown"]=>"-1", $templ["si-charity"]=>"1", $templ["si-school"]=>"2", $templ["si-gov"]=>"3", $templ["si-parent"]=>"4", $templ["si-teacher"]=>"5", $templ["si-individual"]=>"6");
$student_teacher_type_map = array($templ["si-unknown"]=>"-1", $templ["si-single_teacher_multi_grade"]=>"1", $templ["si-single_teacher_single_grade"]=>"2", $templ["si-multi_teacher_single_grade"]=>"3", $templ["si-multi_teacher_multi_grade"]=>"4", $templ["si-parent_homeschool"]=>"5", $templ["si-individual_tutor"]=>"6", $templ["si-self_directed"]=>"7");
$logformats_map = array($templ["si-logformats-pg"]=>"1", $templ["si-logformats-wp"]=>"2");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // We write to /var/www/admin/.apache-include.conf to include uuid in logging as defined in apache2.conf.
        ini_set('display_errors', '0');
	$json = array();
	$json['uuid'] = generate_uuid();
	setPiTimezone();
	$json['date_installed'] = date('Y/m/d H:i:s');;
	$pg_uuid = 'DEFINE PG_UUID ' . $json['uuid'] . PHP_EOL ;
	$pg_logformats = 'ErrorLogFormat "[${PG_UUID}] [%t] [%l] %7F: %E: [client\ %a] %M% ,\ referer\ %{Referer}i"' . PHP_EOL . 'LogFormat "${PG_UUID} %h %l %u %t \"%r\" %>s %O \"%{Referer}i\" \"%{User-Agent}i\"" combined' . PHP_EOL;
	$wp_default_logformats = 'ErrorLogFormat "[%t] [%l] %7F: %E: [client\ %a] %M% ,\ referer\ %{Referer}i"' . PHP_EOL . 'LogFormat "%h %l %u %t \"%r\" %>s %O \"%{Referer}i\" \"%{User-Agent}i\"" combined' . PHP_EOL;
	if(isset($_REQUEST['logformat'])) { $logformat = $_REQUEST['logformat'];} else { $logformat = 1; }
	if($logformat == 1) { $write_logformats = $pg_logformats; } else { $write_logformats = $wp_default_logformats; } 
	// for fields below, -1 as default means not set / unknown
	if(isset($_REQUEST['active'])) { $json['active'] = $_REQUEST['active'];} else { $json['active'] = 1; }
	if(isset($_REQUEST['nickname'])) { $json['nickname'] = $_REQUEST['nickname'];} else { $json['nickname'] = ''; }
	if(isset($_REQUEST['contact_name'])) { $json['contact_name'] = $_REQUEST['contact_name'];} else { $json['contact_name'] = ''; }
	if(isset($_REQUEST['contact_phone'])) { $json['contact_phone'] = $_REQUEST['contact_phone'];} else { $json['contact_phone'] = ''; }
	if(isset($_REQUEST['installer_name'])) { $json['installer_name'] = $_REQUEST['installer_name'];} else { $json['installer_name'] = ''; }
	if(isset($_REQUEST['installer_phone'])) { $json['installer_phone'] = $_REQUEST['installer_phone'];} else { $json['installer_phone'] = ''; }
	if(isset($_REQUEST['country'])) { $json['country'] = $_REQUEST['country'];} else { $json['country'] = ''; }
	if(isset($_REQUEST['location'])) { $json['location'] = $_REQUEST['location'];} else { $json['location'] = ''; }
	if(isset($_REQUEST['location_type'])) { $json['location_type'] = $_REQUEST['location_type'];} else { $json['location_type'] = -1; } // rural (1), urban (10)
	if(isset($_REQUEST['targetgrade_start'])) { $json['targetgrade_start'] = $_REQUEST['targetgrade_start'];} else { $json['targetgrade_start'] = 1; }
	if(isset($_REQUEST['targetgrade_end'])) { $json['targetgrade_end'] = $_REQUEST['targetgrade_end'];} else { $json['targetgrade_end'] = 12; }
	if(isset($_REQUEST['student_teacher_type'])) { $json['student_teacher_type'] = $_REQUEST['student_teacher_type'];} else { $json['student_teacher_type'] = -1; } // multi-grade single-teacher (1), single-grade single-teacher (2), single-grade multi-teacher (3), multi-grade multi-teacher (4), parent / homeschool (5), individual tutor (6), self-directed (7) 
	if(isset($_REQUEST['funding_type'])) { $json['funding_type'] = $_REQUEST['funding_type'];} else { $json['funding_type'] = -1; } // charity funded (1), school funded, govt funded, parent funded, teacher funded, individual funded
	if(isset($_REQUEST['funding_source'])) { $json['funding_source'] = $_REQUEST['funding_source'];} else { $json['funding_source'] = ''; } // who provided funding
	if(isset($_REQUEST['underserved_scale'])) { $json['underserved_scale'] = $_REQUEST['underserved_scale'];} else { $json['underserved_scale'] = -1; } // scale from 1 to 10, where 1 has fewer resourcing options than 10
	if(isset($_REQUEST['default_lang'])) { $json['default_lang'] = $_REQUEST['default_lang'];} else { $json['default_lang'] = 'en'; }
        try {
		$file = fopen($site_info_file,'w+');
     		$json_pretty = json_encode($json, JSON_PRETTY_PRINT);
     		fwrite($file, $json_pretty);
     		fclose($file);
		$file2 = fopen($apache_include_file,'w+');
     		fwrite($file2, $pg_uuid);
     		fclose($file2);
		$file3 = fopen($apache_logFormats_file,'w+');
     		fwrite($file3, $write_logformats);
     		fclose($file3);
        } catch (Exception $ex) {
                header("HTTP/1.1 500 Internal Server Error");
                exit;
        }
}



if (file_exists($site_info_file)){
	error_log("site info error log test");
        $siteinfo = file_get_contents($site_info_file);
        $siteinfo_json = json_decode($siteinfo, true); 
	$loc_type_display = array_search($siteinfo_json['location_type'], $location_type_map);
	$student_teacher_type_display = array_search($siteinfo_json['student_teacher_type'], $student_teacher_type_map);
	$funding_type_display = array_search($siteinfo_json['funding_type'], $funding_type_map);
	$logformats_display = nl2br(file_get_contents($apache_logFormats_file));
        echo "
            <div id='siteDiv' style='margin: 50px 0 50px 0; padding: 10px; border: 1px solid green; background: MintCream;'>
                <h4 id='siteInfoStatus'>{$templ['si-siteInfoStatus']}: {$templ['si-init']}</h4>
                <div id='siteInfo'>
                <table class='version'><tbody>
                <tr><td>{$templ['si-site_name']}:</td><td>{$siteinfo_json['nickname']}</td>
			<td>{$student_teacher_type_display}</td>
                        <td>{$templ['si-grades']}: {$siteinfo_json['targetgrade_start']} - {$siteinfo_json['targetgrade_end']}</td></tr>
                <tr><td>{$templ['si-uuid']}:</td><td>{$siteinfo_json['uuid']}</td><td>{$templ['si-date']}: {$siteinfo_json['date_installed']}</td></tr>
                <tr><td>{$templ['si-contact']}:</td><td>{$siteinfo_json['contact_name']}</td><td>{$siteinfo_json['contact_phone']}</td></tr>
                <tr><td>{$templ['si-installer']}:</td><td>{$siteinfo_json['installer_name']}</td><td>{$siteinfo_json['installer_phone']}</td></tr>
                <tr><td>{$templ['si-location']}:</td><td>{$siteinfo_json['location']}</td><td>{$siteinfo_json['country']}</td><td>{$templ['si-location_type']}: {$loc_type_display}</td></tr>
		<tr><td>{$templ['si-underserved_scale']}:</td><td>{$siteinfo_json['underserved_scale']}</td></tr>
                <tr><td>{$templ['si-funding']}:</td><td>{$funding_type_display}</td><td>{$siteinfo_json['funding_source']}</td></tr>
		<tr><td>{$templ['si-default_lang']}:</td><td>{$siteinfo_json['default_lang']}</td></tr>
		<tr><td>{$templ['si-logformats']}:</td><td colspan=3>{$logformats_display}</td></tr>
                </tbody></table>
                </div>
            </div>
            ";
        
} else {

        if($currlang == 'es'){
                $es_lang_selected = "selected";
                $en_lang_selected = "";
         } else {
                $es_lang_selected = "";
                $en_lang_selected = "selected";
        }
        $startgrade_select = build_selectbox(assoc_range(1, 12), "targetgrade_start", '', $templ["si-start_grade"]);
        $endgrade_select = build_selectbox(assoc_range(1, 12), "targetgrade_end", '', $templ["si-end_grade"]);
	$location_type_select = build_selectbox($location_type_map, "location_type", '', $templ["si-location_type"]);
	$funding_type_select = build_selectbox($funding_type_map, "funding_type", '', $templ["si-funding_type"]);
	$student_teacher_type_select = build_selectbox($student_teacher_type_map, "student_teacher_type", '', $templ["si-student_teacher_type"]);
	$underserved_scale_select = build_selectbox(assoc_range(1, 10), "underserved_scale", '', "{$templ['si-underserved_scale_more']}");
	$logformats_select = build_selectbox($logformats_map, "logformat", 1, '');
	echo "
            <div id='siteDiv' style='margin: 50px 0 50px 0; padding: 10px; border: 1px solid red; background: #fee;'>
            <h4 id='siteInfoStatus'>{$templ['si-siteInfoStatus']}: {$templ['si-uninit']}</h4>
                <div id='siteInfo'><p>{$templ['si-siteInfo_blurb']}</p>
                <form method='POST' id='pg_{$templ["dirname"]}_form' class='pg_site_form' action='{$templ["engine_web_loc"]}'>
                <table class='version'><tbody>
                <tr><td>{$templ['si-site_name']}:</td><td><div><input type='text' id='nickname' name='nickname' placeholder='{$templ['si-site_name']}'></div></td>
			<td>$student_teacher_type_select</td>
			<td>{$startgrade_select} {$endgrade_select}</td></tr>
                <tr><td>{$templ['si-contact']}:</td><td><input type='text' id='contact_name' name='contact_name' placeholder='{$templ['si-contact_name']}'></td>
                        <td><input type='text' id='contact_phone' name='contact_phone' placeholder='{$templ['si-contact_phone']}'></td></tr>
                <tr><td>{$templ['si-installer']}:</td><td><input type='text' id='installer_name' name='installer_name' placeholder='{$templ['si-installer_name']}'></td>
                        <td><input type='text' id='installer_phone' name='installer_phone' placeholder='{$templ['si-installer_phone']}'></td></tr>
                <tr><td>{$templ['si-location']}:</td><td><input type='text' id='location' name='location' placeholder='{$templ['si-city']}'></td>
                        <td><input type='text' id='country' name='country'  placeholder='{$templ['si-country']}'></td><td>$location_type_select</td></tr>
		<tr><td>{$templ['si-underserved_scale']}:</td><td>$underserved_scale_select</td></tr>
		<tr><td>{$templ['si-funding']}:</td><td>$funding_type_select</td>
                        <td><input type='text' id='location' name='funding_source' placeholder='{$templ['si-funding_source']}'></td></tr>
		<tr><td>{$templ['si-default_lang']}:</td><td>
                <select id='default_lang' name='default_lang'>
                        <option value='es' {$es_lang_selected}>{$templ['si-es']}</option>
                        <option value='en' {$en_lang_selected}>{$templ['si-en']}</option>
                </select></td></tr>
		<tr><td>{$templ['si-logformats']}</td><td>$logformats_select</td></tr>
                </tbody></table>
                <input type='hidden' name='active' value='1'/>
                <input type='submit' name='setSiteInfo'  id='SiteInfoButton' value='{$templ['si-submitSiteInfo']}'/>
                </form>
                </div>
            </div>
            ";
}


?>
<?php


function assoc_range($range_start, $range_end) {
	$assoc_array = array();
	for ($i = $range_start; $i <= $range_end; $i++) {
		$assoc_array["{$i}"] = $i;
	}
	return $assoc_array;
}

function build_selectbox($option_array, $element_name, $default, $placeholder) {
        $output = '';
        $output .= '<select name="' . $element_name . '" id="select_' . $element_name . '">';
        if ($placeholder != '') {
                $output .= '<option value="" disabled selected>' . $placeholder  . '</option>';
        }
        foreach($option_array as $key => $value) {
                if ($value == $default) { $output .= '<option value="' . $value . '" selected>' . $key . '</option>' ; }
                else { $output .= '<option value="' . $value . '">' . $key . '</option>' ; }
        }
        $output .= '</select>';
        return $output;
}

function generate_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
                mt_rand( 0, 0xffff ),
                mt_rand( 0, 0x0fff ) | 0x4000,
                mt_rand( 0, 0x3fff ) | 0x8000,
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
}
?>

