<?php
// Include SHT CMS
include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php";
// Delete the rememberme cookie
setcookie("rememberme", "", time() - 3600);
// Log the action
if (isset($_SESSION['login'])) {
    $sht->log("LOGIN", $_SESSION['login'] . " has logged out", $_SERVER['REMOTE_ADDR']);
}
// Destroy all session variables
session_destroy();
// Send the user to the homepage
header("Location: /");
// Do not execute any other code
die();

?>
