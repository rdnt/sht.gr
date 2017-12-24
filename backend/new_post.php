<?php

include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Method is POST
    if (!empty($_POST["title"]) and !empty($_POST["description"]) and !empty($_POST["content"])) {
        // All fields submitted
        $title = $sht->escape_form_input($_POST["title"]);
        $description = $sht->escape_form_input($_POST["description"]);
        $content = $sht->escape_form_input($_POST["content"]);

        if (isset($_SESSION["login"])) {
            // User is logged in
            $username = $_SESSION["login"];
            $user_path = $sht->getDir("accounts") . "$username.json";
            $account = file_exists($user_path);
            if ($account) {
                // User logged in is indeed a user
                $user = file_get_contents($user_path);
                $userdata = json_decode($user, true);

                $admin = $userdata['admin'];
                if ($admin) {
                    // User posting has admin rights
                    $slug = $sht->slugify($title);

                    $post__path = $sht->getDir("accounts") . "$slug.json";

                    $post_data = file_exists($post__path);

                    if (!$post_data) {
                        // Post doesn't already exist.
                        $post = new POST($title, $description, $username, $content);

                        file_put_contents($post__path, json_encode($post, JSON_PRETTY_PRINT));

                        $sht->log("NEW_POST", "$slug created by $username");

                        $sht->response("SUCCESS");
                    }
                    else {
                        $sht->response("POST_ALREADY_EXISTS");
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
        else {
            $sht->response("LOGIN_REQUIRED");
        }
    }
    else {
        $sht->response("FORM_INCOMPLETE");
    }
}
else {
    $sht->response("POST_REQUIRED");
}

?>
