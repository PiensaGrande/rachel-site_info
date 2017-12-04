<script>
// we need to be in a function to call ourselves and reregister the ajax submit function
// if we return data and rebuild the form (perhaps after failed server validation)
function register_button_submit() {

 // ajax background call, adjust as needed to submit form but stay on admin page.
 $("#pg_<?php echo $templ["dirname"]; ?>_form").submit(function(e) {
    var url = "<?php echo $templ["engine_web_loc"]; ?>";
    $.ajax({
           type: "POST",
           url: url,
           data: $("#pg_<?php echo $templ["dirname"]; ?>_form").serialize(),
           success: function(data)
           {
               $("#<?php echo $templ["dirname"]; ?>DivWrapper").html(data);
               register_button_submit();
           },
           error: function(data)
           {
                alert("Error: "+data);
           }
         });

    e.preventDefault();
 });
}

$(function() {
        register_button_submit();
});
</script>
