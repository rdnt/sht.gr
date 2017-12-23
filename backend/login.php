<?php

function escape_form_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = escape_form_input($_POST["username"]);
    $password = escape_form_input($_POST["password"]);

    if($username and $password) {
        // Both username and password fields are filled
        if(strlen($username) > 6 and strlen($username) < 32) {
            // Username has proper length
            if (strlen($password) > 6 and strlen($password) < 32) {
                // Password has proper length
                $account = file_exists($_SERVER['DOCUMENT_ROOT']."/data/accounts/$username.json");
                if ($account) {
                    // User exists
                    $user = file_get_contents($_SERVER['DOCUMENT_ROOT']."/data/accounts/$username.json");
                    $userdata = json_decode($user, true);

                    $valid = password_verify($password, $userdata['hashed_password']);
                    if($valid) {
                        // Password is correct
                        $_SESSION['login'] = $username;
                        $_SESSION['messages'] = $login_msg;
                        echo "SUCCESS";
                    }
                    else {
                        echo "INCORRECT_PASSWORD";
                    }
                }
                else {
                    echo "ACCOUNT_DOES_NOT_EXIST";
                }
            }
            else {
                echo "INVALID_PASSWORD";
            }
        }
        else {
            echo "INVALID_USERNAME";
        }
    }
    else if (!$username and $password){
        echo "EMPTY_USERNAME";
    }
    else if ($username and !$password){
        echo "EMPTY_PASSWORD";
    }
    else {
        echo "EMPTY_USERNAME_PASSWORD";
    }
}
else {
    echo "POST_REQUIRED";
}

?>
