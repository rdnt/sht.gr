<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->loadComponent("head"); ?>
<title><?=$this->getPageTitle(); ?></title>
</head>
<body>
<?php $this->loadComponent("nav"); ?>
<main>
<?php $this->getPageSegment()?>
</main>
<?php $this->loadComponent("footer"); ?>
<?php $this->loadComponent("scripts"); ?>
</body>
</html>
