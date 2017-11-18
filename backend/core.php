<?php
// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Used to reset the cache of certain files
$version = "0.0.0";
// Toggle preloader
$preloader = 0;
// Returns formatted page title
function page_title($title) {
    return "SHT <> $title";
}

?>
