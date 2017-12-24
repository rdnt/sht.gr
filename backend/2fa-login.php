<?php
// Load two-factor authentication library
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
use \RobThree\Auth\TwoFactorAuth;

include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $sht->escape_form_input($_POST["username"]);
    $code = $sht->escape_form_input($_POST["code"]);

    if ($username and $code) {
        // Both username and code fields are filled
        $user_path = $sht->getDir("accounts") . "$username.json";
        $account = file_exists($user_path);
        if ($account) {
            // User exists
            if (isset($_SESSION["login_pending"])) {
                // There is indeed a login pending
                if (strcmp($username, $_SESSION["login_pending"]) === 0) {
                    // User logging in is the same as the user that send the POST
                    $user = file_get_contents($user_path);
                    $userdata = json_decode($user, true);

                    if ($userdata["two_step_auth"] == 1) {
                        // User has enabled two-factor authentication
                        $tfa = new TwoFactorAuth('SHT CMS');
                        if ($tfa->verifyCode($userdata["secret"], $code) === true) {
                            unset($_SESSION['login_pending']);
                            $_SESSION['login'] = $username;
                            $sht->response("SUCCESS");
                            echo $username;
                        }
                        else {
                            $sht->response("INVALID_CODE");
                        }
                    }
                    else {
                        unset($_SESSION['login_pending']);
                        $_SESSION['login'] = $username;
                        $sht->response("SUCCESS");
                    }
                }
                else {
                    $sht->response("INVALID_USERNAME");
                }
            }
            else {
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
    $sht->response("POST_REQUIRED");
}

?>