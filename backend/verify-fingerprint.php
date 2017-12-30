<?php

include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $sht->escape_form_input($_POST["username"]);
    $secret = $sht->escape_form_input($_POST["secret"]);

    if ($username and $secret) {
        // Both username and secret fields are sent
        $user_path = $sht->getDir("accounts") . "$username.json";
        $account = file_exists($user_path);
        if ($account) {
            // User exists
            $user = file_get_contents($user_path);
            $userdata = json_decode($user, true);

            if (strcmp($secret, $userdata["fingerprint-auth-secret"]) === 0) {
                // User authenticator sent the correct token
                if ($userdata["fingerprint-auth"] == 1) {
                    // User has indeed enabled fingerprint authentication
                    $temp_path = $sht->getDir("temp") . "$username.json";
                    $temp_file = file_exists($temp_path);
                    if (!$temp_file) {
                        // File doesn't exist, initialize new login request
                        $sht->response("FINGERPRINT_AUTH_TIMEOUT");
                    }
                    else {
                        // Temp user file exists, read it
                        $temp_user = file_get_contents($temp_path);
                        $temp_user_data = json_decode($temp_user, true);

                        $temp_user_data["allow"] = 1;
                        file_put_contents($temp_path, json_encode($temp_user_data, JSON_PRETTY_PRINT));
                        $sht->response("FINGERPRINT_VERIFIED");
                    }
                }
                else {
                    // User doesn't have fingerprint authentication enabled
                    $sht->response("PERMISSION_DENIED");
                }
            }
            else {
                // User authenticator didn't send correct secret
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
        $sht->response("EMPTY_SECRET");
    }
}
else {
    $sht->response("POST_REQUIRED");
}

?>
