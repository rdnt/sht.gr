<?php
// Load required libraries
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
use Defuse\Crypto\KeyProtectedByPassword;
// Include SHT CMS Core
include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Method is POST
    if (isset($_POST["username"]) and isset($_POST["email"]) and isset($_POST["password"]) and isset($_POST["repeat_password"])) {
        // All fields are sent
        $username = $sht->escape_form_input($_POST["username"]);
        $email = $sht->escape_form_input($_POST["email"]);
        $password = $sht->escape_form_input($_POST["password"]);
        $repeat_password = $sht->escape_form_input($_POST["repeat_password"]);

        if ($username) {
            // Username not empty
            if ($email) {
                // Email not empty
                if ($password) {
                    // Password not empty
                    if ($repeat_password) {
                        // Repeat password not empty
                        if(preg_match($sht->getPattern("username"), $username)) {
                            // Username is in valid format
                            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                // Email is in valid format
                                if(preg_match($sht->getPattern("password"), $password)) {
                                    // Password is in valid format
                                    if (strcmp($password, $repeat_password) === 0) {
                                        // Password and repeat password fields match
                                        $user_path = $sht->getDir("accounts") . "$username.json";
                                        $account = file_exists($user_path);
                                        if (!$account) {
                                            // Account doesn't already exist
                                            // Generate the password hash
                                            $password_hash = password_hash($password, PASSWORD_DEFAULT);
                                            // Generate and encode the user's encryption key
                                            $protected_key = KeyProtectedByPassword::createRandomPasswordProtectedKey($password);
                                            $protected_key_encoded = $protected_key->saveToAsciiSafeString();
                                            // Initialize user data
                                            $user_data = array(
                                                "username"                          => $username,
                                                "password-hash"                     => $password_hash,
                                                "encoded-encryption-key"            => $protected_key_encoded,
                                                "code-auth"                         => 0,
                                                "encrypted-code-auth-secret"        => "",
                                                "fingerprint-auth"                  => 0,
                                            	"fingerprint-auth"                  => "",
                                            	"admin-role"                        => 0,
                                                "rememberme"                        => array()
                                            );
                                            // Save the data
                                            file_put_contents($user_path, json_encode($user_data, JSON_PRETTY_PRINT));
                                            // Respond with success message
                                            $sht->response("SUCCESS");
                                        }
                                        else {
                                            $sht->response("ACCOUNT_ALREADY_EXISTS");
                                        }
                                    }
                                    else {
                                        $sht->response("PASSWORDS_DONT_MATCH");
                                    }
                                }
                                else {
                                    $sht->response("INVALID_PASSWORD");
                                }
                            }
                            else {
                                $sht->response("INVALID_EMAIL");
                            }
                        }
                        else {
                            $sht->response("INVALID_USERNAME");
                        }
                    }
                    else {
                        $sht->response("EMPTY_REPEAT_PASSWORD");
                    }
                }
                else {
                    $sht->response("EMPTY_PASSWORD");
                }
            }
            else {
                $sht->response("EMPTY_EMAIL");
            }
        }
        else {
            $sht->response("EMPTY_USERNAME");
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
