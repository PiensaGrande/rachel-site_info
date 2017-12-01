<?php namespace pg_site_info; ?>
<?php include "template.php";?>
<?php
$stat_loc = "/admin/pg-stats.php";

// $whereAmi here handles multi-source includes like $_REQUEST handles mult-source forms.
// $whereAmi = $stat_loc;
$whereAmi = $_SERVER['SCRIPT_NAME'];                     

// Add UUID to to $logdata and setup for adding to name of direct download files 
    $site_file = $_SERVER['DOCUMENT_ROOT'] . "/site_info.json";
    $uuid = '1';  // default for not set.
    if(file_exists($site_file)) {
                $contents = file_get_contents($site_file);
                // if site_file found we want uuid in all logs.
                if ($contents) {
                        $site_info = json_decode($contents);
                        if(isset($site_info->uuid)) {
                        	$uuid = $site_info->uuid ;
                	} else {
				$uuid = '1'; 
			}
                }
    }
    $logdata['uuid'] = $uuid;
//  End code snippet on UUID

   $whereAmi = $_SERVER['SCRIPT_NAME'];                     // $whereAmi here handles multi-source includes like $_REQUEST handles mult-source forms.

// First we handle info only requests to be as fast as possible.

   if(isset($_REQUEST['jsonStatInfo'])) {
	$response = array();
	if($uuid !== '1') {
		$jsonresponse = $contents;
	} else {
		$response['uuid'] = $uuid;
		$jsonresponse = json_encode($response);
	}
	echo $jsonresponse;
	exit;
   } 

// Next we handle form requests
if (isset($_REQUEST['dl_site_info'])) {
        if (is_readable($site_file)) {
            header("content-type: text/plain");
            if(isset($_REQUEST['dl_direct'])) { header("Content-Disposition: attachment; filename='{$uuid}-site_info.json'"); }
            readfile($site_file);
            exit;
        } else {
             exit;
        }
}

// Finally we show stat_links if included from rachel stats page.
// We wrap this in a case statement to handle being included from anywhere when someone wants to populate $site_info or set $logdata['uuid']
// thus rachelLogger could include us and have those things ready.
   switch($whereAmi) {
	case $stat_loc:
      		echo print_stat_links($templ);
      		return true;
		break;
	default:
		// note that the $site_info object and $logdata['uuid'] has been set.
		return true;
		break;
   }

function print_stat_links($templ) {
	$output = "";
	$output .= "
		<div class='statsmodule' data-moduletype='{$templ['module_type']}' data-title='{templ['title']}' data-img_uri='{$templ['img_uri']}' data-index_loc='{$templ['index_loc']}'>
		<h3>{$templ['title']} Stats</h3>
		<ul>
        		<li><a href=\"/modules/site_info/rachel-stats.php?dl_direct=1&dl_site_info=1\">{$templ['si-download_json']}</a> 
		</ul>
		</div>";
	return $output;
}
	
?>
