<!DOCTYPE html>
<html lang="en">
<head>
<? $core->loadComponent("head") ?>
<title><?= $core->title ?></title>
</head>
<body>
<main>
<? $core->loadContent() ?>
</main>
<? $core->loadComponent("scripts") ?>
</body>
</html>
