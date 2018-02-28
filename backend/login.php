<?php
// Load required libraries
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
use Defuse\Crypto\KeyProtectedByPassword;
// Include SHT CMS Core
include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php";
// Verify request method is POST
$sht->checkPOST();
// Check if all fields are sent
if (!isset($_POST["username"]) or !isset($_POST["password"])) {
    $sht->response("FORM_DATA_MISSING");
    // die
}
// Assign username and password their values
$username = $sht->escape_input($_POST["username"]);
$password = $sht->escape_input($_POST["password"]);
// Check if username is empty
if (!$username) {
    $sht->response("EMPTY_USERNAME");
    // die
}
// Check if password is empty
if (!$password) {
    $sht->response("EMPTY_PASSWORD");
    // die
}
// Check if username is invalid
if (!preg_match($sht->getPattern("username"), $username)) {
    $sht->response("INVALID_USERNAME");
    // die
}
// Check if password is invalid
if(!preg_match($sht->getPattern("password"), $password)) {
    $sht->response("INVALID_PASSWORD");
    // die
}
// Check if account exists
if (!file_exists($sht->getDir("accounts") . "$username.json")) {
    $sht->response("ACCOUNT_DOES_NOT_EXIST");
    // die
}
// Read userdata
$user = file_get_contents($sht->getDir("accounts") . "$username.json");
$userdata = json_decode($user, true);
// Check if password is correct
if (!password_verify($password, $userdata['password-hash'])) {
    // Log the failure
    $sht->log("LOGIN", "$username: Login failed: Incorrect password", $_SERVER['REMOTE_ADDR']);
    $sht->response("INCORRECT_PASSWORD");
    // die
}
// Decode encryption key with password
$protected_key_encoded = $userdata["encoded-encryption-key"];
$protected_key = KeyProtectedByPassword::loadFromAsciiSafeString($protected_key_encoded);
$user_key = $protected_key->unlockKey($password);
$user_key_encoded = $user_key->saveToAsciiSafeString();
// Check for the rememberme field
if (isset($_POST["rememberme"])) {
    $remember_me = $sht->escape_input($_POST["rememberme"]);
}
else {
    $remember_me = 0;
}
// Check if user has any other authentication methods enabled
if ($userdata["code-auth"] != 1 and $userdata["fingerprint-auth"] != 1) {
    // Perform log in
    $_SESSION['login'] = $username;
    // Create user cookie if the rememberme field is set
    if ($remember_me == 1) {
        $sht->setcookie($username);
    }
    // Log successful login
    $sht->log("LOGIN", "$username has logged in", $_SERVER['REMOTE_ADDR']);
    $sht->response("SUCCESS");
}
else if ($userdata["code-auth"] != 1) {
    // User only has code authentication enabled
    $_SESSION['code-auth'] = $username;
    $_SESSION['user-key'] = $user_key_encoded;
    if ($remember_me == 1) {
        $_SESSION['rememberme'] = 1;
    }
    $sht->log("LOGIN", "$username is logging in using code authentication", $_SERVER['REMOTE_ADDR']);
    $sht->response("REQUIRE_CODE_AUTH");
}
else if ($userdata["fingerprint-auth"] != 1) {
    // User only has fingerprint authentication enabled
    $_SESSION['fingerprint-auth'] = $username;
    if ($remember_me == 1) {
        $_SESSION['rememberme'] = 1;
    }
    $sht->log("LOGIN", "$username is logging in using fingerprint authentication", $_SERVER['REMOTE_ADDR']);
    $sht->response("REQUIRE_FINGERPRINT_AUTH");
}

?>
