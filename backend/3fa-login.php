<?php

include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_SESSION['login_three_factor'])) {
        $username = $_SESSION['login_three_factor'];
        $token = $sht->escape_form_input($_POST["token"]);

        if ($token) {
            // A token was received
            if ($username) {
                // Valid pending login
                $user_path = $sht->getDir("accounts") . "$username.json";
                $account = file_exists($user_path);
                if ($account) {
                    // User exists
                    $user = file_get_contents($user_path);
                    $userdata = json_decode($user, true);

                    if ($userdata["three_step_auth"] == 1) {
                        // User has enabled three-factor authentication
                        /////////////////
                        $sht->response("AWAITING_FINGERPRINT");
                    }
                    else {
                        unset($_SESSION['login_three_factor']);
                        $_SESSION['login'] = $username;
                        $sht->response("SUCCESS");
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
            $sht->response("EMPTY_TOKEN");
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
