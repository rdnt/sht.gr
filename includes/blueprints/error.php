<!DOCTYPE html>
<html lang="en">
<head>
<?php $shell->loadComponent("head"); ?>
<title><?=$shell->title?></title>
</head>
<body>
<main>
<?php $shell->loadContent()?>
</main>
<?php $shell->loadComponent("scripts"); ?>
</body>
</html>
