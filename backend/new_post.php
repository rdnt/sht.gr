<?php

function escape_form_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function response($message) {
    echo $message;
    die();
}

function log_action() {

}

function slugify($data) {
    // replace non letter or digits by -
    $data = preg_replace('~[^\pL\d]+~u', '-', $data);
    // transliterate
    $data = iconv('utf-8', 'us-ascii//TRANSLIT', $data);
    // remove unwanted characters
    $data = preg_replace('~[^-\w]+~', '', $data);
    // trim
    $data = trim($data, '-');
    // remove duplicate -
    $data = preg_replace('~-+~', '-', $data);
    // lowercase
    $data = strtolower($data);

    if (empty($data)) {
        return null;
    }
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = escape_form_input($_POST["title"]);
    $description = escape_form_input($_POST["description"]);
    $content = escape_form_input($_POST["content"]);
    $username = $_SESSION['login'];

    if ($username) {
        // User is logged in
        $user_path = $_SERVER['DOCUMENT_ROOT']."/data/accounts/$username.json";
        $account = file_exists($user_path);
        if ($account) {
            // User logged in is indeed a user
            $user = file_get_contents($user_path);
            $userdata = json_decode($user, true);

            $admin = $userdata['admin'];
            if ($admin) {
                // User posting has admin rights
                if($title and $description and $content) {
                    // All data has been submitted
                    $slug = slugify($title);

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
                        response("SUCCESS");
                    }
                    else {
                        response("POST_ALREADY_EXISTS");
                    }
                }
                else {
                    response("FORM_INCOMPLETE");
                }
            }
            else {
                response("PERMISSION_DENIED");
            }
        }
        else {
            response("ACCOUNT_DOES_NOT_EXIST");
        }
    }
    else {
        response("LOGIN_REQUIRED");
    }
}
else {
    response("POST_REQUIRED");
}

?>
