<?php
/**
 * SHT Core
 *
 * A placeholder class for my projects that contains helpful methods.
 *
 * @author    Tasos Papalyras <tasos@sht.gr>
 * @copyright 2018 SHT
 * @license   https://github.com/ShtHappens796/Core/blob/master/LICENSE MIT License
 * @version   0.1.0
 * @link      https://github.com/ShtHappens796/Core
 */

// Abstract class that contains all core functions needed
abstract class Core {
    // Private datamembers
    protected $root;
    protected $name;
    protected $title_separator;
    protected $patterns;
    // Constructor
    function __construct() {
        // Initialize private datamembers
        $this->root = $_SERVER['DOCUMENT_ROOT'];
        $this->name = "Core";
        $this->title_separator = "›";
        // Start the session if it wasn't already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        echo $_SESSION['login'] . "<br><br>";
    }
    // Enables debugging
    static function enableDebugging() {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
    // Returns the relative page path
    function getPagePath($page) {
        $pages_path = $this->root . "/includes/pages/";
        return $pages_path . $page . ".php";
    }
    // Returns the page's title
    function getPageTitle($page) {
        return $this->name . " $this->title_separator " . ucfirst($page);
    }
    // Loads all the components found in the /backend/core/components/ folder
    static function loadComponents() {
        foreach (glob($_SERVER['DOCUMENT_ROOT'] . "/backend/core/components/*.php") as $filename) {
            include $filename;
        }
    }
    // Returns the regular expression for the requested property
    function getPattern($pattern) {
        return $this->patterns[$pattern];
    }

}

// Load the shell and all components
CORE::loadComponents();
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/core/Shell.php";
