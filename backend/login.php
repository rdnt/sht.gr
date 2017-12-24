<?php

include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $sht->escape_form_input($_POST["username"]);
    $password = $sht->escape_form_input($_POST["password"]);

    if($username and $password) {
        // Both username and password fields are filled
        if(strlen($username) > 6 and strlen($username) < 32) {
            // Username has proper length
            if (strlen($password) > 6 and strlen($password) < 32) {
                // Password has proper length
                $account = file_exists($sht->getDir("accounts") . "$username.json");
                if ($account) {
                    // User exists
                    $user = file_get_contents($sht->getDir("accounts") . "$username.json");
                    $userdata = json_decode($user, true);

                    $valid = password_verify($password, $userdata['hashed_password']);
                    if($valid) {
                        // Password is correct
                        // Store the username in the session cookie
                        $_SESSION['login_pending'] = $username;

                        $sht->log("LOGIN", "$username has logged in", $_SERVER['REMOTE_ADDR']);

                        $sht->response("REQUIRE_TWO_STEP_AUTH");
                    }
                    else {
                        $sht->response("INCORRECT_PASSWORD");
                    }
                }
                else {
                    $sht->response("ACCOUNT_DOES_NOT_EXIST");
                }
            }
            else {
                $sht->response("INVALID_PASSWORD");
            }
        }
        else {
            $sht->response("INVALID_USERNAME");
        }
    }
    else if (!$username and $password){
        $sht->response("EMPTY_USERNAME");
    }
    else if ($username and !$password){
        $sht->response("EMPTY_PASSWORD");
    }
    else {
        $sht->response("EMPTY_USERNAME_PASSWORD");
    }
}
else {
    $sht->response("POST_REQUIRED");
}

?>
