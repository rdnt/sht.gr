<?php

include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php";
// Fingerprint authentication timeframe
$timeframe = 35;

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
                            and date("U") - $temp_user_data["date"] < $timeframe) {
                            // Authenticated using fingerprint for this token,
                            // not n seconds after the login was requested
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
                        else if (strcmp($token, $temp_user_data["token"]) !== 0) {
                            // Another login is taking place right now
                            if (date("U") - $temp_user_data["date"] >= $timeframe) {
                                // n seconds have passed after that login,
                                // nullify the login and start await
                                //$temp_user_data["old"] = $token;
                                //file_put_contents($temp_path, json_encode($temp_user_data, JSON_PRETTY_PRINT));

                                $temp_user = array(
                                    "username" => $username,
                                    "token"    => $token,
                                    "date"     => date("U"),
                                    "allow"    => 0
                                );
                                file_put_contents($temp_path, json_encode($temp_user, JSON_PRETTY_PRINT));
                                $sht->response("FINGERPRINT_AUTH_RESET");
                            }
                            else {
                                $sht->response("FINGERPRINT_AUTH_DUPLICATE");
                            }
                        }
                        else if ($temp_user_data["allow"] != 1 and date("U") - $temp_user_data["date"] >= $timeframe) {
                            // Still waiting for a fingerprint but timeout has passed
                            // Nullify the login
                            $temp_user_data["allow"] = -1;
                            $temp_user_data["old"] = $token;
                            file_put_contents($temp_path, json_encode($temp_user_data, JSON_PRETTY_PRINT));
                            $sht->response("FINGERPRINT_AUTH_TIMEOUT");
                        }
                        else if ($temp_user_data["allow"] != 1) {
                            $sht->response("AWAITING_FINGERPRINT");
                        }
                        else if (date("U") - $temp_user_data["date"] >= $timeframe) {
                            // n seconds have passed, but the login was not confirmed
                            if (date("U") - $temp_user_data["date"] >= $timeframe * 2) {
                                // Last login was n seconds ago, allow this one
                                // to continue (a minute has passed)
                                $temp_user = array(
                                    "username" => $username,
                                    "token"    => $token,
                                    "date"     => date("U"),
                                    "allow"    => 0
                                );
                                file_put_contents($temp_path, json_encode($temp_user, JSON_PRETTY_PRINT));
                                $sht->response("FINGERPRINT_AUTH_RESET");
                            }
                            else {
                                // This login is less than n seconds after last login
                                // Do not allow it
                                $sht->response("PERMISSION_DENIED");
                            }
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
