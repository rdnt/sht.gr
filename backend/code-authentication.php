<?php
// Load two-factor authentication library
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
use \RobThree\Auth\TwoFactorAuth;

include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['code-authentication'])) {
        $username = $_SESSION['code-authentication'];
        $code = $sht->escape_form_input($_POST["code"]);

        if ($username and $code) {
            // Both username and code fields are filled
            $user_path = $sht->getDir("accounts") . "$username.json";
            $account = file_exists($user_path);
            if ($account) {
                // User exists
                $user = file_get_contents($user_path);
                $userdata = json_decode($user, true);

                if ($userdata["code-authentication"] == 1) {
                    // User has indeed enabled code authentication
                    $tfa = new TwoFactorAuth('SHT CMS');
                    if ($tfa->verifyCode($userdata["code-authentication-secret"], $code) === true) {
                        // Code entered is correct in this timeframe
                        if ($userdata["fingerprint-authentication"] != 1) {
                            // User doesn't have fingerprint authentication enabled
                            // Log them in
                            unset($_SESSION['code-authentication']);
                            $_SESSION['login'] = $username;
                            $sht->log("LOGIN", "$username has logged in", $_SERVER['REMOTE_ADDR']);
                            $sht->response("SUCCESS");
                        }
                        else {
                            // User has fingerprint authentication enabled
                            $_SESSION['fingerprint-authentication'] = $username;
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
                    unset($_SESSION['code-authentication']);
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
