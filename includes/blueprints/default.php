<!DOCTYPE html>
<html lang="en">
<head>
<?php $shell->loadComponent("head"); ?>
<title><?=$shell->title?></title>
</head>
<body>
<?php $shell->loadComponent("nav"); ?>
<main class="light playing">
<?php $shell->loadContent()?>
</main>
<?php $shell->loadComponent("footer"); ?>
<?php $shell->loadComponent("scripts"); ?>
</body>
</html>
