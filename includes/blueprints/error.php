<!DOCTYPE html>
<html lang="en">
<head>
<?php $sht->loadComponent("head"); ?>
<title><?=$sht->title?></title>
</head>
<body>
<main>
<?php $sht->loadContent()?>
</main>
<?php $sht->loadComponent("scripts"); ?>
</body>
</html>
