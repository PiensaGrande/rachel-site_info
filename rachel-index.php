<?php namespace pg_site_info; ?>
<?php 
// Place module specific hints for RACHEL in template.php
// For a simple module, that will be all that is necessary.
include dirname(__FILE__) . "/template.php"; 

// Permit template.php to define whether we show anything on index.
// Remember that hiding in admin will cause rachel-admin.php to be hidden as well.
if (strtoupper($templ["hide_index"]) == "YES") { return; }

// Here we build core module structure with logo, title
// Note the availability of this data to jquery using data-
echo "
<div class='indexmodule' data-moduletype='{$templ['module_type']}' data-title='{templ['title']}' data-img_uri='{$templ['img_uri']}' data-index_loc='{$templ['index_loc']}'>
<a href='{$templ['index_loc']}'>
<img src='{$templ['img_uri']}' alt='Your Content Logo'>
</a>
<h2><a href='{$templ['index_loc']}'>{$templ['title']}</a></h2>
";

// If you have any links or additional info to provide do it here, extend $templ in messages.php for multi-lingual.
// Comment out the description if not used.
//echo "<p>{$templ["description"]}</p>";

$site_info_file = $_SERVER["DOCUMENT_ROOT"] .  "/site_info.json";
if (file_exists($site_info_file)){
        $siteinfo = file_get_contents($site_info_file);
        $siteinfo_json = json_decode($siteinfo, true);
        echo "
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
            ";

} else {
	echo "<p>{$templ["description"]}</p>";
	if (isset($_COOKIE['rachel-auth']) && $_COOKIE['rachel-auth'] == "admin") {
          echo "<small style='float:right;'><a href=\"{$templ['admin_web_loc']}\">[{$templ['si-goto_admin']}]</a></small>";
	}
}
echo "</div>";
?>
