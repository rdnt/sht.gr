<!DOCTYPE html>
<html lang="en">
<head>
<? $core->loadComponent("head") ?>
<title><?= $core->getTitle() ?></title>
</head>
<body>
<? $core->loadComponent("nav") ?>
<main>
<? $core->loadContent() ?>
</main>
<? $core->loadComponent("footer") ?>
<? $core->loadComponent("scripts") ?>
<? $core->appendScripts() ?>
</body>
</html>
