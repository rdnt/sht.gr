<!DOCTYPE html>
<html lang="en">
<head>
<?php $sht->loadComponent("head"); ?>
<title><?=$sht->title?></title>
</head>
<body>
<?php $sht->loadComponent("nav"); ?>
<main>
<?php $sht->loadContent()?>
</main>
<div id="side-reveal"></div>
<div id="background-img"></div>
<?php $sht->loadComponent("footer"); ?>
<?php $sht->loadComponent("scripts"); ?>
</body>
</html>
