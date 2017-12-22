<?php namespace pg_site_info; ?>
<?php 
include dirname(__FILE__) . "/template.php";

// This is a rachel-admin.php file. It is an optional file that RACHEL uses to
// display your module on the RACHEL admin page to allow access to admin-specific files or functions.
// You should place this file in your module's directory if needed.
// As it uses the template.php file, you should be able to set your specific info there.

echo "<div class='adminmodule' data-moduletype='{$templ['module_type']}' data-title='{$templ['title']}' data-img_uri='{$templ['img_uri']}' data-index_loc='{$templ['index_loc']}'>";

// Place your admin code here.

// We use an engine which processes a form in the background if called from a POST
// note that a button with jquery script to ajax submit doesn't work if this is called 
// directly (unless the extension is running) because there is no header to place jquery in the page.
// If the site_info.json exists, the engine displays the data else it provides a form in additon to handling the form.

echo "<div id='{$templ['dirname']}DivWrapper'>";
include $templ["engine_loc"];
echo "</div></div>";
include $templ["js_loc"];
?>
