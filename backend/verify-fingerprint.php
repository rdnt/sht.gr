<?php

include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php";

$username = "ShtHappens796";

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

?>
