<?php

include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['login_pending'];

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
            }
            else {
                unset($_SESSION['login_pending']);
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
    $sht->response("POST_REQUIRED");
}

?>
