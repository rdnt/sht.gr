<?php
// Used to reset the files' cache
$version = "0.1.1";
// Disable preloader for all users
$preloader = 0;
// Enable error reporting
$errors = 1;
// Default timezone to Europe/Athens
date_default_timezone_set("Europe/Athens");

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

function push_assets($version) {
    $assets = array(
        "/css/style.css?v=$version" => "style",
        "/js/init.js?v=$version" => "script",
        "/css/materialize.min.css?v=$version" => "style",
        "/js/materialize.min.js?v=$version" => "script"
    );

    $counter = count($assets);

    foreach ($assets as $asset => $as) {
        $counter--;
        $string = "Link: <$asset>; rel=preload; as=$as";
        header($string, false);
    }
}

push_assets($version);

?>
