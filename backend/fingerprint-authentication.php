<?php

include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Method is POST
    if (isset($_SESSION['fingerprint-authentication']) and isset($_POST["token"]) and isset($_SESSION['rememberme'])) {
        // All fields are sent
        $username = $_SESSION['fingerprint-authentication'];
        $token = $sht->escape_form_input($_POST["token"]);
        $rememberme = $_SESSION['rememberme'];

        if ($username and $token) {
            // No fields are empty
            $user_path = $sht->getDir("accounts") . "$username.json";
            $account = file_exists($user_path);
            if ($account) {
                // User exists
                $user = file_get_contents($user_path);
                $userdata = json_decode($user, true);

                if ($userdata["fingerprint-authentication"] == 1) {
                    // User has indeed enabled fingerprint authentication
                    $temp_path = $sht->getDir("temp") . "$username.json";
                    $temp_file = file_exists($temp_path);
                    if (!$temp_file) {
                        // File doesn't exist, initialize new login request
                        $temp_user = array(
                            "username" => $username,
                            "token"    => $token,
                            "date"     => date("U"),
                            "allow"    => 0
                        );
                        file_put_contents($temp_path, json_encode($temp_user, JSON_PRETTY_PRINT));
                        // /!\ Send notification to phone /!\
                        $sht->response("AWAITING_FINGERPRINT");
                    }
                    else {
                        // Temp user file exists, read it
                        $temp_user = file_get_contents($temp_path);
                        $temp_user_data = json_decode($temp_user, true);
                        if ($temp_user_data["allow"] == 1
                            and strcmp($token, $temp_user_data["token"]) === 0
                            and date("U") - $temp_user_data["date"] < 30) {
                            // Authenticated using fingerprint for this token,
                            // not 30 seconds after the login was requested
                            // Log the user in
                            unset($_SESSION['fingerprint-authentication']);
                            unlink($temp_path);
                            $_SESSION['login'] = $username;
                            if ($rememberme == 1) {
                                $sht->setcookie($username);
                            }
                            $sht->log("LOGIN", "$username has logged in", $_SERVER['REMOTE_ADDR']);
                            $sht->response("SUCCESS");
                        }
                        else if ($temp_user_data["allow"] != 1) {
                            $sht->response("AWAITING_FINGERPRINT");
                        }
                        else if (strcmp($token, $temp_user_data["token"]) !== 0) {
                            // Another login is taking place right now and for
                            // The next 1-30 seconds
                            $sht->response("FINGERPRINT_AUTH_DUPLICATE");
                        }
                        else if (date("U") - $temp_user_data["date"] < 30) {
                            // 30 seconds have passed, nullify the login
                            unlink($temp_path);
                            $sht->response("FINGERPRINT_AUTH_TIMEOUT");
                        }
                        else {
                            $sht->response("PERMISSION_DENIED");
                        }
                    }
                }
                else {
                    // User doesn't have fingerprint authentication enabled
                    unset($_SESSION['fingerprint-authentication']);
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
