<?php namespace pg_site_info; ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] .  "/admin/common.php"); ?>
<?php
// This is simple module manifest used by RACHEL to display info. 
// Used in rachel-index.php, rachel-admin.php, and rachel-stats.php
// To extend $templ for module specific messages, place in messages.php.
// TODO: i'd like to see the indexes on the control related stuff reflecting some path info so that
//       if the data is a web location, that is in the index, if it is full path for an include, that is clear as well.
//       requires changing the index names throughout the code, thus index_loc becomes index_web_loc and js_loc becomes js_inc_loc.

$lang1 = getlang();
$templ = array();
$tmpl_dir = str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname(__FILE__));

// By including messages here instead of after the translated bits, we draw attention to it for newcomers,
// It also means that we will treat the associations in template.php as authoritative.
// These two files need to remain separate because the plan is to have template.php read from
// a manifest.json file which can be written to programmatically thus enabling a UI for module customizations.
// and leaving this file to merely parse manifest.json and load the messages.

include "messages.php";

// UI related
$templ["title"] = "Site Info";
$templ["description"] = "Generate UUID and track installation info."; 
$templ["img_uri"] = "{$tmpl_dir}/logo.png";
$templ["index_loc"] = "{$tmpl_dir}/index.php";
$templ["admin_web_loc"] = "{$tmpl_dir}/rachel-admin.php";
$templ["stats_web_loc"] = "{$tmpl_dir}/rachel-stats.php";

// Control related
$templ["dirname"] = basename(__DIR__);
$templ["engine_loc"] = dirname(__FILE__) . "/site_info.php";
$templ["js_loc"] = dirname(__FILE__) . "/site_info.js.php";
$templ["web_path"] = $tmpl_dir;
$templ["engine_web_loc"] = "{$tmpl_dir}/site_info.php";
$templ["module_type"] = "admin_module";
$templ["hide_index"] = "yes";

// Override with language translations where appropriate / when available
// Note that we don't place english as default here so that we have one complete set of translations
// coming in and we can permit partials below.
switch ($lang1) {
	case ("es"):
		$templ["title"] = "Información del Sitio"; 
		$templ["description"] = "Cree su propio UUID, cargue su información del sitio.";
		break;
	// could add new language translations here as extra cases
	// don't be tempted to create a default here because if we define the default before the case statement
	// we get the added benefit of support for partial translations where we've created a full set before this point.
}

?>
