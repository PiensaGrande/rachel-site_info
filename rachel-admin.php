<?php namespace pg_site_info; ?>
<?php 
include "template.php";

// This is a rachel-admin.php file. It is an optional file that RACHEL uses to
//     display your module on the RACHEL admin page to allow access to admin-specific files or functions. 
//     You should place this file in your module's directory if needed.
//     As it uses the template.php file, you should be able to set your specific info there.

echo "<div class='adminmodule' data-moduletype='{$templ['module_type']}' data-title='{$templ['title']}' data-img_uri='{$templ['img_uri']}' data-index_loc='{$templ['index_loc']}'>";

// Place your admin code here.

// We use an engine which processes a form in the background if called from a POST and then
// display's either the site_info or a form to enter site info if the json doesn't exist yet.
// note we've set the engine such that it doesn't have to run ajax in case jquery is disabled.
// or this file is called directly.

echo "<div id='{$templ['dirname']}DivWrapper'>";
include $templ["engine_loc"];
echo "</div></div>";
include $templ["js_loc"];
?>
