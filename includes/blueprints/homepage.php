<!DOCTYPE html>
<html lang="en">
<head>
<?php $sht->loadComponent("head"); ?>
<title><?=$sht->title?></title>
</head>
<body>
<main>
<?php $sht->loadComponent("nav"); ?>
<?php $sht->loadContent()?>
</main>
<?php $sht->loadComponent("light-footer"); ?>
<?php $sht->loadComponent("scripts"); ?>
</body>
</html>
