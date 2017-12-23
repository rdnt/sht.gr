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
            $user_path = $_SERVER['DOCUMENT_ROOT']."/data/accounts/$username.json";
            $account = file_exists($user_path);
            if ($account) {
                // User logged in is indeed a user
                $user = file_get_contents($user_path);
                $userdata = json_decode($user, true);

                $admin = $userdata['admin'];
                if ($admin) {
                    // User posting has admin rights
                    $slug = $sht->slugify($title);

                    $post_json_path = $_SERVER['DOCUMENT_ROOT']."/data/posts/$slug.json";
                    $post_md_path = $_SERVER['DOCUMENT_ROOT']."/data/posts/$slug.md";

                    $post_data = file_exists($post_json_path);
                    $post_content =  file_exists($post_md_path);

                    if (!$post_data and !$post_content) {
                        // Post doesn't already exist.
                        $postjson = array(
                            "title"        => $title,
                            "slug"         => $slug,
                            "description"  => $description,
                            "author"       => $username,
                            "date_created" => date("Ymd_His"),
                            "date_updated" => date("Ymd_His"),
                            "reactions"       => 0,
                            "comments"     => array()
                        );

                        file_put_contents($post_json_path, json_encode($postjson, JSON_PRETTY_PRINT));
                        file_put_contents($post_md_path, $content);

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
