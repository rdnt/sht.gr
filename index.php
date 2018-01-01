<?php include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/head.php"; ?>
<title><?=$sht->page_title("Home")?></title>
</head>
<body>
<?php

if (isset($_SESSION['login'])) {
    echo $_SESSION['login'];
}
else {
    echo "Not logged in";
}


?>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/preloader.php"; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/nav.php"; ?>
<main>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/pages/home.php"; ?>
</main>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/footer.php"; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/scripts.php"; ?>
</body>
</html>
