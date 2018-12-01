<!DOCTYPE html>
<html lang="en">
<head>
<?php $core->loadComponent("head") ?>
<title><?= $core->getTitle() ?></title>
</head>
<body>
<?php $core->loadComponent("nav") ?>
<main>
<?php $core->loadContent() ?>
</main>
<?php $core->loadComponent("footer") ?>
<?php $core->loadComponent("scripts") ?>
<?php $core->appendScripts() ?>
</body>
</html>
