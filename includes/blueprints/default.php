<!DOCTYPE html>
<html lang="en">
<head>
<?php $core->loadComponent("head"); ?>
<title><?=$core->title?></title>
</head>
<body>
<?php $core->loadComponent("nav"); ?>
<main>
<?php $core->loadContent()?>
</main>
<?php $core->loadComponent("footer"); ?>
<?php $core->loadComponent("scripts"); ?>
</body>
</html>
