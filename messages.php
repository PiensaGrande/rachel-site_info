<?php namespace pg_site_info; ?>
<?php
global $lang1;

// default english // Site Info
$templ['si-siteInfoStatus'] = "Información del Sitio de Instalación";
$templ['si-init'] = "Inicializada";
$templ['si-uninit'] = "Sin Inicializar";
$templ['si-siteInfo_blurb'] = "El sitio de instalación requiere inicialización.";
$templ['si-submitSiteInfo'] = "Establecer la información del sitio";
$templ['si-site_name'] = "Nombre del Sitio";
$templ['si-uuid']= "UUID";
$templ['si-contact'] = "Contacto";
$templ['si-contact_name'] = "Nombre de Contacto";
$templ['si-contact_phone'] = "Tel. de contacto";
$templ['si-installer'] = "Instalador";
$templ['si-installer_name'] = "Nombre de Instalador";
$templ['si-installer_phone'] = "Tel. de Instalador";
$templ['si-location'] = "Lugar";
$templ['si-city'] = "Ciudad";
$templ['si-country'] = "País";
$templ['si-default_lang'] = "Idioma Principal";
$templ['si-es'] = "Español";
$templ['si-en'] = "Inglés";
$templ['si-date'] = "Fecha";
$templ['si-grades'] = "Grados";
$templ['si-start_grade'] = "Grado de Inicio";
$templ['si-end_grade'] = "Grado Final";
$templ["si-goto_admin"] = "Goto Admin";
$templ["si-download_json"] = "Download SiteInfo JSON";
$templ["disk_space_avail"] = "Available disk space";
$templ["no_space_for_new"] = "Insufficient disk space to create new module.";
$templ["just_image"] = "Image";
$templ["just_title"] = "Title";
$templ["just_description"] = "Description";
$templ["large_file"] = "is too large";
$templ["fix_errors"] = "Please fix the following errors";
$templ["required"] = "is required";
$templ["special_chars"] = "Please eliminate the special characters";
$templ["allowed_chars_title"] = "Only alphamumeric characters, underscores, and dashes are allowed in the title";
$templ["no_upload_space"] = "There is not sufficient disk space to upload this image";
$templ["upload_your_content"] = "Upload your content!";
$templ["file_to_upload"] = "File to upload";
$templ["select"] = "Select";
$templ["content_type"] = "Content type";
$templ["upload"] = "Upload";
$templ["delete"] = "Delete";
$templ["error"] = "Error";
$templ["preview"] = "Preview";
$templ["save"] = "Save";
$templ["new"] = "New";
$templ["optional"] = "Optional";
$templ["finished"] = "Finished";
$templ["saved"] = "Saved!";
$templ["are_you_sure"] = "Are you sure?";
$templ["delete_element"] = "Delete Element";

// override with language translations when available
// This allows for partial translations to exists
switch ($lang1) {
	case ("es"):
                // Site Info
                $templ['si-siteInfoStatus'] = "Información del Sitio de Instalación";
                $templ['si-init'] = "Inicializada";
                $templ['si-uninit'] = "Sin Inicializar";
                $templ['si-siteInfo_blurb'] = "El sitio de instalación requiere inicialización.";
                $templ['si-submitSiteInfo'] = "Establecer la información del sitio";
                $templ['si-site_name'] = "Nombre del Sitio";
                $templ['si-uuid']= "UUID";
                $templ['si-contact'] = "Contacto";
                $templ['si-contact_name'] = "Nombre de Contacto";
                $templ['si-contact_phone'] = "Tel. de contacto";
                $templ['si-installer'] = "Instalador";
                $templ['si-installer_name'] = "Nombre de Instalador";
                $templ['si-installer_phone'] = "Tel. de Instalador";
                $templ['si-location'] = "Lugar";
                $templ['si-city'] = "Ciudad";
                $templ['si-country'] = "País";
                $templ['si-default_lang'] = "Idioma Principal";
                $templ['si-es'] = "Español";
                $templ['si-en'] = "Inglés";
                $templ['si-date'] = "Fecha";
                $templ['si-grades'] = "Grados";
                $templ['si-start_grade'] = "Grado de Inicio";
                $templ['si-end_grade'] = "Grado Final";
		$templ["si-goto_admin"] = "Ir a Admin";
		$templ["si-download_json"] = "Descarga Información del Sitio JSON";
		$templ["no_space_for_new"] = "Insuficiente espacio en disco para crear.";
		$templ["fix_errors"] = "Arreglar los siguientes errores";
		$templ["required"] = "es requerido";
		$templ["special_chars"] = "Por favor, elimina los caracteres especiales"; 
		$templ["allowed_chars_title"] = "Sólo caracteres alfanuméricos, _ y - están permitidos en el Título";
		$templ["no_upload_space"] = "No hay suficiente espacio en el disco para cargar";
		$templ["upload_your_content"] = "¡Carga su contenido!";
		$templ["file_to_upload"] = "Archivo para cargar";
		$templ["select"] = "Seleccione";
		$templ["content_type"] = "Tipo de contenido";
		$templ["upload"] = "Cargar";
		$templ["delete"] = "Borrar";
		$templ["error"] = "Error";
		$templ["preview"] = "Preestreno";
		$templ["save"] = "Guardar";
		$templ["new"] = "Nuevo";
		$templ["optional"] = "Opcional";
		$templ["finished"] = "Acabado";
		$templ["saved"] = "¡Se guardó!";
		$templ["are_you_sure"] = "¿Seguro?";
		$templ["title_uri_required"] = "Título y Enlace necesitan valores";
		$templ["delete_element"] = "Borrar Elemento";
		break;
	// can support additional languages via extra cases 
}

?>
