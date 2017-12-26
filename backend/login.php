<?php

include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $sht->escape_form_input($_POST["username"]);
    $password = $sht->escape_form_input($_POST["password"]);

    if ($username and $password) {
        // Both username and password fields are filled
        if (strlen($username) >= 6 and strlen($username) <= 16) {
        //if (preg_match('/^{6,16}$/', $username)) {
            // Username has proper length
            if (strlen($password) >= 8 and strlen($password) <= 32) {
            //if (preg_match('/^{6,16}$/', $password)) {
                // Password has proper length
                $account = file_exists($sht->getDir("accounts") . "$username.json");
                if ($account) {
                    // User exists
                    $user = file_get_contents($sht->getDir("accounts") . "$username.json");
                    $userdata = json_decode($user, true);

                    $valid = password_verify($password, $userdata['password-hash']);
                    if($valid) {
                        // Password is correct
                        // Store the username in the session cookie
                        if ($userdata["code-authentication"] != 1 and $userdata["fingerprint-authentication"] != 1) {
                            // User has no other authentication methods
                            // Log them in
                            $_SESSION['login'] = $username;
                            $sht->log("LOGIN", "$username has logged in", $_SERVER['REMOTE_ADDR']);
                            $sht->response("SUCCESS");
                        }
                        else {
                            if ($userdata["code-authentication"] == 1) {
                                // User has code authentication enabled
                                $_SESSION['code-authentication'] = $username;
                                $sht->log("LOGIN", "$username is logging in using code authentication", $_SERVER['REMOTE_ADDR']);
                                $sht->response("REQUIRE_CODE_AUTH");
                            }
                            else if ($userdata["fingerprint-authentication"] == 1) {
                                // User has fingerprint  authentication enabled and not code generator
                                $_SESSION['fingerprint-authentication'] = $username;
                                $sht->log("LOGIN", "$username is logging in using fingerprint authentication", $_SERVER['REMOTE_ADDR']);
                                $sht->response("REQUIRE_FINGERPRINT_AUTH");
                            }
                        }
                    }
                    else {
                        $sht->log("LOGIN", "$username: Login failed: Incorrect password", $_SERVER['REMOTE_ADDR']);
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
