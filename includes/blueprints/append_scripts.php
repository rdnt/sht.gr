<!DOCTYPE html>
<html lang="en">
<head>
<?php require_once $_SERVER['DOCUMENT_ROOT']."/includes/components/head.php"; ?>
<title><?=$this->getPageTitle(); ?></title>
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT']."/includes/components/nav.php"; ?>
<main>
<?php $this->getPageSegment("<!-- SCRIPTS -->", 0)?>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT']."/includes/components/footer.php"; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT']."/includes/components/scripts.php"; ?>
<?php $this->getPageSegment("<!-- SCRIPTS -->", 1); ?>
</body>
</html>
