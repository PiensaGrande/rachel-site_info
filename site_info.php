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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // We write to /var/www/admin/.apache-include.conf to include uuid in logging as defined in apache2.conf.
        ini_set('display_errors', '0');
	$json = array();
	$json['uuid'] = generate_uuid();
	setPiTimezone();
	$json['date_installed'] = date('Y/m/d H:i:s');;
	$pg_uuid = 'DEFINE PG_UUID ' . $json['uuid'] . PHP_EOL ;
	$pg_logformats = 'ErrorLogFormat "[${PG_UUID}] [%t] [%l] %7F: %E: [client\ %a] %M% ,\ referer\ %{Referer}i"' . PHP_EOL . 'LogFormat "${PG_UUID} %h %l %u %t \"%r\" %>s %O \"%{Referer}i\" \"%{User-Agent}i\"" combined' . PHP_EOL;
	// for fields below, -1 as default means not set.
	if(isset($_REQUEST['active'])) { $json['active'] = $_REQUEST['active'];} else { $json['active'] = 1; }
	if(isset($_REQUEST['nickname'])) { $json['nickname'] = $_REQUEST['nickname'];} else { $json['nickname'] = ''; }
	if(isset($_REQUEST['contact_name'])) { $json['contact_name'] = $_REQUEST['contact_name'];} else { $json['contact_name'] = ''; }
	if(isset($_REQUEST['contact_phone'])) { $json['contact_phone'] = $_REQUEST['contact_phone'];} else { $json['contact_phone'] = ''; }
	if(isset($_REQUEST['installer_name'])) { $json['installer_name'] = $_REQUEST['installer_name'];} else { $json['installer_name'] = ''; }
	if(isset($_REQUEST['installer_phone'])) { $json['installer_phone'] = $_REQUEST['installer_phone'];} else { $json['installer_phone'] = ''; }
	if(isset($_REQUEST['country'])) { $json['country'] = $_REQUEST['country'];} else { $json['country'] = ''; }
	if(isset($_REQUEST['location'])) { $json['location'] = $_REQUEST['location'];} else { $json['location'] = ''; }
	if(isset($_REQUEST['location_type'])) { $json['location_type'] = $_REQUEST['location_type'];} else { $json['location_type'] = -1; } // Urban / Rural
	if(isset($_REQUEST['targetgrade_start'])) { $json['targetgrade_start'] = $_REQUEST['targetgrade_start'];} else { $json['targetgrade_start'] = 1; }
	if(isset($_REQUEST['targetgrade_end'])) { $json['targetgrade_end'] = $_REQUEST['targetgrade_end'];} else { $json['targetgrade_end'] = 12; }
	if(isset($_REQUEST['student_teacher_type'])) { $json['student_teacher_type'] = $_REQUEST['student_teacher_type'];} else { $json['student_teacher_type'] = -1; } // traditonal, multi-grade, tutor, homeschool
	if(isset($_REQUEST['funding_type'])) { $json['funding_type'] = $_REQUEST['funding_type'];} else { $json['funding_type'] = -1; } // school funded, govt funded, charity funded, parent funded, teacher funded, individual funded
	if(isset($_REQUEST['funding_source'])) { $json['funding_source'] = $_REQUEST['funding_source'];} else { $json['funding_source'] = ''; } // who provided funding
	if(isset($_REQUEST['underserved_scale'])) { $json['underserved_scale'] = $_REQUEST['underserved_scale'];} else { $json['underserved_scale'] = -1; } // level of options
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
     		fwrite($file3, $pg_logformats);
     		fclose($file3);
        } catch (Exception $ex) {
                header("HTTP/1.1 500 Internal Server Error");
                exit;
        }
}



if (file_exists($site_info_file)){
        $siteinfo = file_get_contents($site_info_file);
        $siteinfo_json = json_decode($siteinfo, true); 
        echo "
            <div id='siteDiv' style='margin: 50px 0 50px 0; padding: 10px; border: 1px solid green; background: MintCream;'>
                <h4 id='siteInfoStatus'>{$templ['si-siteInfoStatus']}: {$templ['si-init']}</h4>
                <div id='siteInfo'>
                <table class='version'><tbody>
                <tr><td>{$templ['si-site_name']}:</td><td>{$siteinfo_json['nickname']}</td><td>{$templ['si-grades']}: {$siteinfo_json['targetgrade_start']} - {$siteinfo_json['targetgrade_end']}</td></tr>
                <tr><td>{$templ['si-uuid']}:</td><td>{$siteinfo_json['uuid']}</td><td>{$templ['si-date']}: {$siteinfo_json['date_installed']}</td></tr>
                <tr><td>{$templ['si-contact']}:</td><td>{$siteinfo_json['contact_name']}</td><td>{$siteinfo_json['contact_phone']}</td></tr>
                <tr><td>{$templ['si-installer']}:</td><td>{$siteinfo_json['installer_name']}</td><td>{$siteinfo_json['installer_phone']}</td></tr>
                <tr><td>{$templ['si-location']}:</td><td>{$siteinfo_json['location']}</td><td>{$siteinfo_json['country']}</td></tr>
                <tr><td>{$templ['si-default_lang']}:</td><td>{$siteinfo_json['default_lang']}</td></tr>
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
        $startgrade_select = build_selectbox(range(1, 12), "targetgrade_start", '', $templ["si-start_grade"]);
        $endgrade_select = build_selectbox(range(1, 12), "targetgrade_end", '', $templ["si-end_grade"]);
	echo "
            <div id='siteDiv' style='margin: 50px 0 50px 0; padding: 10px; border: 1px solid red; background: #fee;'>
            <h4 id='siteInfoStatus'>{$templ['si-siteInfoStatus']}: {$templ['si-uninit']}</h4>
                <div id='siteInfo'><p>{$templ['si-siteInfo_blurb']}</p>
                <form method='POST' id='pg_{$templ["dirname"]}_form' class='pg_site_form' action='{$templ["engine_web_loc"]}'>
                <table class='version'><tbody>
                <tr><td>{$templ['si-site_name']}:</td><td><div><input type='text' id='nickname' name='nickname' placeholder='{$templ['si-site_name']}'></div></td><td>{$startgrade_select} {$endgrade_select}</td></tr>
                <tr><td>{$templ['si-contact']}:</td><td><input type='text' id='contact_name' name='contact_name' placeholder='{$templ['si-contact_name']}'></td>
                        <td><input type='text' id='contact_phone' name='contact_phone' placeholder='{$templ['si-contact_phone']}'></td></tr>
                <tr><td>{$templ['si-installer']}:</td><td><input type='text' id='installer_name' name='installer_name' placeholder='{$templ['si-installer_name']}'></td>
                        <td><input type='text' id='installer_phone' name='installer_phone' placeholder='{$templ['si-installer_phone']}'></td></tr>
                <tr><td>{$templ['si-location']}:</td><td><input type='text' id='location' name='location' placeholder='{$templ['si-city']}'></td>
                        <td><input type='text' id='country' name='country'  placeholder='{$templ['si-country']}'></td></tr>
                <tr><td>{$templ['si-default_lang']}:</td><td>
                <select id='default_lang' name='default_lang'>
                        <option value='es' {$es_lang_selected}>{$templ['si-es']}</option>
                        <option value='en' {$en_lang_selected}>{$templ['si-en']}</option>
                </select></td></tr>
                </tbody></table>
                <input type='hidden' name='active' value='1'/>
                <input type='hidden' name='location_type' value='-1'/>
                <input type='hidden' name='student_teacher_type' value='-1'/>
                <input type='hidden' name='funding_type' value='-1'/>
                <input type='hidden' name='funding_source' value='-1'/>
                <input type='hidden' name='underserved_scale' value='-1'/>
                <input type='submit' name='setSiteInfo'  id='SiteInfoButton' value='{$templ['si-submitSiteInfo']}'/>
                </form>
                </div>
            </div>
            ";
}


?>
<?php

function build_selectbox($option_array, $element_name, $default, $placeholder) {
        $output = '';
        $output .= '<select name="' . $element_name . '" id="select_' . $element_name . '">';
        if ($placeholder != '') {
                $output .= '<option value="" disabled selected>' . $placeholder  . '</option>';
        }
        foreach($option_array as $value) {
                if ($value == $default) { $output .= '<option value="' . $value . '" selected>' . $value . '</option>' ; }
                else { $output .= '<option value="' . $value . '">' . $value . '</option>' ; }
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

