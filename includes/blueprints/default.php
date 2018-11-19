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
<?php $sht->loadComponent("footer"); ?>
<?php $sht->loadComponent("scripts"); ?>
</body>
</html>
