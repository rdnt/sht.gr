<?php
// Used to reset the files' cache
$version = "0.0.0";
// Disable preloader for all users
$preloader = 1;
// Enable error reporting
$errors = 1;

function page_title($title) {
    // Returns formatted page title
    return "SHT <> $title";
}

if ($errors) {
    // Error reporting
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

if (session_status() == PHP_SESSION_NONE) {
    // Start the session if it wasn't already started
    session_start();
}

?>
