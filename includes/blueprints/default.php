<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/head.php"; ?>
<title><?=$shell->getPageTitle(); ?></title>
</head>
<body>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/nav.php"; ?>
<main>
<?php $shell->getPageSegment()?>
</main>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/footer.php"; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/scripts.php"; ?>
</body>
</html>
