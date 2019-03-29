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
<?php $sht->loadComponent("footer"); ?>
</main>
<?php $sht->loadComponent("scripts"); ?>
</body>
</html>
