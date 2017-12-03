<?php include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/head.php"; ?>
<title><?=page_title("Blog")?></title>
</head>
<body>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/preloader.php"; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/nav.php"; ?>
<main>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/pages/blog.php"; ?>
</main>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/footer.php"; ?>
</body>
</html>