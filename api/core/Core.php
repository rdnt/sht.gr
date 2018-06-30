<?php

/**
 *
 * SHT Core
 *
 * The Core provides a basic interface for any project I create,
 * handles module autoloading, request redirection to the backend,
 * asset pushing, blueprint-based page rendering and basically any functionality
 * that all of my projects need. It is extendable,
 *
 * @author    Tasos Papalyras <tasos@sht.gr>
 * @copyright 2018 ShtHappens796
 * @license   https://github.com/ShtHappens796/Core/blob/master/LICENSE MIT
 * @version   0.1.0
 * @link      https://github.com/ShtHappens796/Core
 *
 */

$GLOBALS['debug'] = true;
// Abstract class that contains all core functions needed
abstract class Core {
    // Private datamembers
    private $domain;
    private $root;
    private $current_page;
    protected $name;
    protected $title_separator;
    protected $patterns;
    protected $pages;
    protected $data_paths;
    protected $title;
    protected $assets;
    protected $folders;
    // Constructor
    function __construct() {
        // Initialize private datamembers
        if ($GLOBALS['debug'] === true) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
        $this->domain = $_SERVER['SERVER_NAME'];
        $this->root = $_SERVER['DOCUMENT_ROOT'];
        $this->current_page = $_SERVER['REQUEST_URI'];
        if (array_key_exists($this->current_page, $this->pages)){
            $this->title = $this->name . " $this->title_separator " . $this->pages[$this->current_page][0];
        }
        else {
            $this->title = $this->name . " $this->title_separator Error 404";
        }
        if(!isset($_COOKIE['PHPSESSID'])) {
            $this->pushAssets();
        }
        // Start the session if it wasn't already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    // Returns the document root
    function getRoot() {
        return $this->root;
    }
    // Returns the regular expression for the requested property
    function getPattern($pattern) {
        return $this->patterns[$pattern];
    }
    // Returns the current page URI
    function getCurrentPage() {
        return $this->current_page;
    }
    // Overrides the current page URI
    function setCurrentPage($page) {
        $this->current_page = $page;
    }
    function getDomain() {
        return $this->domain;
    }
    // Initializes the Core
    static function initialize() {
        CORE::loadModules("/api/core/modules");
        CORE::loadModules("/api/shell/modules");
    }
    // Loads all the modules
    static function loadModules($path) {
        // Prepare the iterator
        $core = new RecursiveDirectoryIterator($_SERVER['DOCUMENT_ROOT'] . $path);
        $iterator = new RecursiveIteratorIterator($core);
        $modules = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);
        // Load all modules in the directory structure recursively
        foreach ($modules as $component => $filename) {
            require_once $component;
        }
    }
    // Create data paths if they don't exist
    function createDataPaths() {
        foreach ($this->data_paths as $path) {
            if (!file_exists($this->root . $path)) {
                mkdir($this->root . $path);
            }
        }
    }
    // Redirects to a specific page
    function redirect($page) {
        header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $this->getDomain() . $page);
        die();
    }
    // Returns the current page's title based on the request URI
    function getPageTitle() {
        return $this->title;
    }
    // Returns the page path
    function getPagePath($page) {
        if (array_key_exists($this->current_page, $this->pages)){
            return $this->root . "/includes/pages/" . $this->pages[$page][1] . ".php";
        }
        else {
            return $this->root . "/includes/error/404.php";
        }
    }
    // Get a specific page part based on a separator
    function getPageSegment($separator = null, $offset = 0) {
        $page = $this->getCurrentPage();
        if (!$separator) {
            if (file_exists($this->getPagePath($page))) {
                require_once $this->getPagePath($page);
            }
            return;
        }
        $path = $this->getPagePath($page);
        $string = file_get_contents($path);
        $segments = explode($separator, $string);
        if(array_key_exists($offset, $segments)){
            $segment = $segments[$offset];
            if (substr($segment, 0, 5) !== "<?php") {
                $segment = "?>" . $segment;
            }
            eval($segment);
        }
    }
    // Returns the blueprint selected for a page
    function getBlueprint($page) {
        $parameters = explode("/", $page);
        $page = $parameters[0];
        if (array_key_exists($page, $this->pages)){
            return $this->pages[$page][2];
        }
        else {
            return "error";
        }
    }
    // Returns the absolute path of a blueprint
    function getBlueprintPath() {
        $blueprints_path = $this->root . "/includes/blueprints/";
        $blueprint = $this->getBlueprint($this->getCurrentPage());
        return $blueprints_path . $blueprint . ".php";
    }
    // Renders a page depending on a blueprint
    function renderPage() {
        $parameters = explode("/", $this->getCurrentPage());
        $folder = $parameters[0];
        if (!in_array($folder, $this->folders) && $folder !== "api") {
            $name = $this->getCurrentPage();
            require_once $this->getBlueprintPath();
        }
    }
}
// Initialize the Core
CORE::initialize();
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/shell/Shell.php";
