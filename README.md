# rachel-site_info

site_info serves the following purposes...

*to create a unique identifier for a specific installation of RACHEL.

*to track installation information (contacts and structure) for the installer to reference offline.

*to provide installer contact information to the administrators of RACHEL.

*to provide UUID availability to rachelLogger() to be used by other modules.

*to incorporate installation information to feature vectors of machine learning algorithms (UUID in access_logs crossed against site_info.json)

After filling out a small form, an installer will have a json file in the document root directory called site_info.json.

rachel-stats.php provides links to a direct download of that file with the UUID in the name so that site info for multiple installs on the same day
can be saved to your cell phone and emailed or archived without any additional processing.  The json format allows for easy parsing 
into a master database at a later date.  

The direct download method with UUID in the name is our preferred method for storing logs to a cell phone when one is visiting
multiple locations.  Note that our image uses this method for all RACHEL core log files once the UUID has been generated. A cell
phone can be set to auto download all log files when the phone connects to the hotspot without the risk of deleting files from another location.

If RACHEL core has been updated to support inclusion of per module files, 
this module supports inclusion of rachel-index.php, rachel-stats.php, and rachel-admin.php.

This module also creates two hidden files with UUID and LogFormat information in /var/www/admin.
For these to affect apache, two IncludeOptional directives have to be set in /etc/apache2/apache2.conf.
Set first one at the top of the file so the variable is usable throughout, set the second after the other logFormats.
IncludeOptional /var/www/admin/.apache-*-include.conf
IncludeOptional /var/www/admin/.apache-*-logFormats.conf

Changes to the apache configuration will not show until apache has been restarted.

This module also makes the rachelLogger() function much more useful by incorporating UUID into things like searchHistory.log
and loginHistory.log.  Merely including rachel-stats.php before calling rachelLogger() would make $logdata['uuid'] set correctly.

Finally, this module introduces a module manifest in the form of template.php and messages.php which allow a single module
to function across multiple languages and moves things like module title, logo location, and description into a single template file.

TODO:  

*adjust the form interface to remove PG specific defaults for funding source and funding type

*add error messages when attempting to download prior to creating site-info.json

*decide if we wish to support editing of json elements besides the UUID

*create rachel-help.php to show contact information in a popup once discussion has occurred relative to including a lightbox in index.php

*create doc to expand on importance of UUID and site specific information to eventual training of ML for AI.

*discuss support of per-module includes in all admin tabs such that a module writer can decide where to place their div by naming their file appropriately.
