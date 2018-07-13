<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->loadComponent("head"); ?>
<title><?=$this->getPageTitle(); ?></title>
</head>
<body>
<?php $this->loadComponent("nav"); ?>
<main>
<?php $this->getPageSegment("<!-- SCRIPTS -->", 0)?>
</main>
<?php $this->loadComponent("footer"); ?>
<?php $this->loadComponent("scripts"); ?>
<?php $this->getPageSegment("<!-- SCRIPTS -->", 1); ?>
</body>
</html>
