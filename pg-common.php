<?php namespace pg_site_info; ?>
<?php

function setPiTimezone() {
  if (file_exists("/usr/bin/raspi-config") || file_exists("/etc/fake-raspi-config")) { # for testing on non-raspi systems
    if (file_exists("/etc/timezone")) {
        $f_contents = file_get_contents("/etc/timezone");
        if ($f_contents) {
                $timezone = preg_replace('~[\r\n]+~', '', $f_contents);
        }
    }
    date_default_timezone_set($timezone);
    return true;
  }
}

    // rachelLogger()... add uuid to all logs, direct log types to appropriate locations, but fail silently if we have less than about 50MB of disk space left.

function rachelLogger($logdata=array()) {
    $logdir = $_SERVER['DOCUMENT_ROOT'];
    $reserved_req = 50000;  // somewhat arbitrary, but we don't consider our logs more important than os reboot needs.
    exec("df {$logdir}", $exec_out, $exec_err);
    $str = rtrim($exec_out[1]);
    $pieces = preg_split('/\s+/', $str);
    $avail = $pieces[sizeof($pieces) - 3]; // in KB

    if($avail > $reserved_req) {
    	// if we are to process logs on a country wide basis in Hadoop or otherwise, we need a unique identifier in each log.
    	// The next bit grabs the UUID out of site_info.json if it exists and appends it to all logs.
    	$site_file = $_SERVER['DOCUMENT_ROOT'] . "/site_info.json";
    	if(file_exists($site_file)) {
      		$contents = file_get_contents($site_file);
      		// if site_file found we want uuid in all logs.
      		if ($contents) {
              		$site_info = json_decode($contents);
              		if(isset($site_info->uuid)) {
                	$uuid = $site_info->uuid ;
              	} else { $uuid = '1'; }
      			$logdata['uuid'] = $uuid;
      		}
    	}

	setPiTimezone();
        $logdata["date"] = date('Y-m-d H:i:s');
        if (isset($_SESSION['rachel_user_id'])) {
                $logdata['user_id'] = $_SESSION['rachel_user_id'];
                $logdata['username'] = $_SESSION['rachel_username'];
        } else {
                $logdata['user_id'] = -1;
                $logdata['username'] = '';
        }
        if (isset($_COOKIE['rachel-auth']) && $_COOKIE['rachel-auth'] == "admin") {
             $logdata['user_id'] = 0;
             $logdata['username'] = 'admin';
        }
	switch($logdata['type']) {
		case 'search':
                	$log_file = $logdir . "/searchHistory.log";
			break;
		case 'suggest':
                	$log_file = $logdir . "/suggest404.log";
			break;
		case 'disclaimer':
                	$log_file = $logdir . "/disclaimerHistory.log";
			break;
		case 'marcaMala':
                	$log_file = $logdir . "/marcaMalaHistory.log";
			break;
		case 'login':
                	$log_file = $logdir . "/loginHistory.log";
			break;
		default:
                	$log_file = $logdir . "/mixedUse.log";  // since we are using json objects on each line, they don't have to be the same.
	}
        $json_logdata = json_encode($logdata);
        error_log($json_logdata . PHP_EOL,3,$log_file);
    }
    return true;
}
?>
