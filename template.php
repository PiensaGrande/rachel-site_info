<?php namespace pg_site_info; ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] .  "/admin/common.php"); ?>
<?php
// This is simple module manifest used by RACHEL to display info. 
// Used in rachel-index.php, rachel-admin.php, and rachel-stats.php
// To extend $templ for module specific messages, place in messages.php.

$lang1 = getlang();
$templ = array();
if(isset($dir)) { 
	$tmpl_dir = $dir ;
} else {
	$tmpl_dir = dirname(__FILE__);
}

// hide_index is for special case modules that may not need a display to students
$templ["hide_index"] = "yes";
$templ["index_loc"] = "{$tmpl_dir}/index.php";
$templ["title"] = "Site Info";
$templ["description"] = "Generate UUID and track installation info."; 
$templ["img_uri"] = "{$tmpl_dir}/logo.png";
$templ["dirname"] = "site_info";
$templ["module_type"] = "admin_module";

// Override with language translations where appropriate / when available
// Note that we don't place english as default here so that we can have partial translations.
switch ($lang1) {
	case ("es"):
		$templ["title"] = "Información del Sitio"; 
		$templ["description"] = "Cree su propio UUID, cargue su información del sitio.";
		break;
	// could add new language translations here as extra cases
}

include "messages.php";
?>
