<?php namespace pg_site_info; ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] .  "/admin/common.php"); ?>
<?php
    $preflang = getlang();
    require_once($_SERVER["DOCUMENT_ROOT"] . "/admin/lang/lang.$preflang.php");
    include dirname(__FILE__) . "/template.php";
?>
<!DOCTYPE html>
<html lang="<?php echo $lang['langcode'] ?>">
<head>
<meta charset="utf-8">
<title>RACHEL - <?php echo $lang['home'] ?></title>
<link rel="stylesheet" href="/css/normalize-1.1.3.css">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/ui-lightness/jquery-ui-1.10.4.custom.min.css">
<script src="/js/jquery-1.10.2.min.js"></script>
<script src="/js/jquery-ui-1.10.4.custom.min.js"></script>
</head>

<body>
<div id="rachel">
    <div id="adminnav"><a href="/admin/modules.php"><?php echo $lang['admin'] ?></a></div>
</div>

<div class="menubar cf">
    <ul>
    <li><a href="/index.php" target="_self"><?php echo strtoupper($lang['home']) ?></a></li>
    <li><a href="/about.html" target="_self"><?php echo strtoupper($lang['about']) ?></a></li>
    </ul>
</div>

<div id="content">
<?php include $templ['engine_loc']; ?>
</div>
<?php include $templ['js_loc']; ?>
<div class="menubar cf" style="margin-bottom: 80px; position: relative;">
    <ul>
    <li><a href="/index.php" target="_self"><?php echo strtoupper($lang['home']) ?></a></li>
    <li><a href="/about.html" target="_self"><?php echo strtoupper($lang['about']) ?></a></li>
    </ul>
</div>

</body>
</html>
