<?php
// Example response
$params = array(
    "password" => "asdad"
);
$post = $core->validate($params);
$core->response("SUCCESS", $post['password']);
