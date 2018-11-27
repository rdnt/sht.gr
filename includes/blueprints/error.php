<!DOCTYPE html>
<html lang="en">
<head>
<? $core->loadComponent("head") ?>
<title><?= $core->getTitle() ?></title>
</head>
<body>
<main>
<? $core->loadContent() ?>
</main>
<? $core->loadComponent("scripts") ?>
</body>
</html>
