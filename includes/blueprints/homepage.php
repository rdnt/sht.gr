<!DOCTYPE html>
<html lang="en">
<head>
<?php $core->loadComponent("head") ?>
<title><?= $core->getTitle() ?></title>
</head>
<body>
<main>
<?php $core->loadComponent("nav") ?>
<?php $core->loadContent() ?>
</main>
<?php $core->loadComponent("light-footer") ?>
<?php $core->loadComponent("scripts") ?>
<?php $core->appendScripts() ?>
</body>
</html>
