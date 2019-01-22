<?php
// Example response
$params = array(
    "password"
);
$post = $core->validate($params);
$core->apply_rate_limiting("endpoint");
$core->response("SUCCESS", $post['password']);
