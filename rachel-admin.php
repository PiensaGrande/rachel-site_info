<?php namespace pg_site_info; ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] .  "/admin/common.php"); ?>
<?php include "template.php";?>
<!-- This is a rachel-admin.php file. It is an optional file that RACHEL uses to
     display your module on the RACHEL admin page to allow access to admin-specific files or functions. 
     You should place this file in your module's directory if needed.
     As it uses the template.php file, you should be able to set your specific info there.
-->

<div class='adminmodule' data-moduletype='{$templ['module_type']}' data-title='{templ['title']}' data-img_uri='{$templ['img_uri']}' data-index_loc='{$templ['index_loc']}'>
<?php
// Place your admin code here.

// We use an engine which processes a form in the background if called from a POST and then
// display's either the site_info or a form to enter site info if the json doesn't exist yet.
// note we've set the engine such that it doesn't have to run ajax in case jquery is disabled.
// or this file is called directly.

$engine_loc = dirname(__FILE__) . "/site_info.php";
$web_path = str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname(__FILE__));
$engine_web_loc = $web_path . "/site_info.php";
echo "<div id='siteDivWrapper'>";
include $engine_loc ;
echo "</div>";
?>
</div>

<script>
// onload
$(function() {

 // ajax background call, adjust as needed to submit form but stay on admin page.
 $("#pg_siteinfo_form").submit(function(e) {
    var url = "<?php echo $engine_web_loc; ?>";
    $.ajax({
           type: "POST",
           url: url,
           data: $("#pg_siteinfo_form").serialize(),
           success: function(data)
           {
               $("#siteDivWrapper").html(data);
               register_site_info_submit();
           },
           error: function(data)
           {
                alert("Error: "+data);
           }
         });

    e.preventDefault();
 });

}); // end onload
</script>
