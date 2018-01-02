<?php
// Load required libraries
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
use \RobThree\Auth\TwoFactorAuth;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
// Include SHT CMS Core
include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Method is POST
    if (isset($_SESSION['code-auth']) and isset($_POST["code"]) and isset($_SESSION['rememberme']) and isset($_SESSION['user-key'])) {
        // All fields are sent
        $username = $_SESSION['code-auth'];
        $code = $sht->escape_form_input($_POST["code"]);
        $rememberme = $_SESSION['rememberme'];

        if ($username and $code and $_SESSION['user-key']) {
            // No fields are empty
            $user_path = $sht->getDir("accounts") . "$username.json";
            $account = file_exists($user_path);
            if ($account) {
                // User exists
                $user = file_get_contents($user_path);
                $userdata = json_decode($user, true);

                if ($userdata["code-auth"] == 1) {
                    // User has indeed enabled code authentication
                    // Decrypt code authentication secret from userdata
                    $user_key_encoded = $_SESSION['user-key'];
                    $user_key = Key::loadFromAsciiSafeString($user_key_encoded);

                    $encrypted_code_auth_secret = $userdata["encrypted-code-auth-secret"];

                    try {
                        $code_auth_secret = Crypto::decrypt($encrypted_code_auth_secret, $user_key);
                    }
                    catch (Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
                        $sht->log("SECURITY", "$username encountered decryption error while authenticating using a generated code", $_SERVER['REMOTE_ADDR']);
                        $sht->response("PERMISSION_DENIED");
                    }

                    $tfa = new TwoFactorAuth('SHT CMS');
                    if ($tfa->verifyCode($code_auth_secret, $code) === true) {
                        // Code entered is correct in this timeframe
                        if ($userdata["fingerprint-auth"] != 1) {
                            // User doesn't have fingerprint authentication enabled
                            // Log them in
                            unset($_SESSION['code-auth']);
                            unset($_SESSION['user-key']);
                            $_SESSION['login'] = $username;
                            if ($rememberme == 1) {
                                $sht->setcookie($username);
                            }
                            $sht->log("LOGIN", "$username has logged in", $_SERVER['REMOTE_ADDR']);
                            $sht->response("SUCCESS");
                        }
                        else {
                            // User has fingerprint authentication enabled
                            $_SESSION['fingerprint-auth'] = $username;
                            $sht->log("LOGIN", "$username is logging in using fingerprint authentication", $_SERVER['REMOTE_ADDR']);
                            $sht->response("REQUIRE_FINGERPRINT_AUTH");
                        }
                    }
                    else {
                        $sht->log("LOGIN", "$username: Login failed: Incorrect code", $_SERVER['REMOTE_ADDR']);
                        $sht->response("INCORRECT_CODE");
                    }
                }
                else {
                    // User doesn't have code authentication enabled
                    unset($_SESSION['code-auth']);
                    unset($_SESSION['user-key']);
                    $sht->response("PERMISSION_DENIED");
                }
            }
            else {
                $sht->response("ACCOUNT_DOES_NOT_EXIST");
            }
        }
        else if (!$username) {
            $sht->response("EMPTY_USERNAME");
        }
        else {
            $sht->response("EMPTY_CODE");
        }
    }
    else {
        $sht->response("PERMISSION_DENIED");
    }
}
else {
    $sht->response("POST_REQUIRED");
}

?>
