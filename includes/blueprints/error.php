<!DOCTYPE html>
<html lang="en">
<head>
<?php $core->loadComponent("head") ?>
<title><?= $core->getTitle() ?></title>
</head>
<body>
<main>
<?php $core->loadContent() ?>
</main>
<?php $core->loadComponent("scripts") ?>
</body>
</html>
