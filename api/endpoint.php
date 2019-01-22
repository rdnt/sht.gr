<?php
// Example response
$params = array(
    "password"
);
$post = $core->validate($params);
$core->response("SUCCESS", $post);
