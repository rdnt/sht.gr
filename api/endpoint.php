<?php
// Example response
$params = [
    "outer_variable" => [
        // "inner_variable" => [
        //     "inner_string_variable",
        //     "inner_string_variable_with_regex" => "password"
        // ],
        "outer_string_variable",
        "outer_string_variable_with_regex" => "password"
    ],
    "string_variable",
    "string_variable_with_regex" => "password"
];
$post = $core->validate($params);
$core->response("SUCCESS");
