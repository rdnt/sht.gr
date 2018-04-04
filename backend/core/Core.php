<?php

$GLOBALS['debug'] = true;

/**
 * SHT Core
 *
 * A placeholder class for my projects that contains helpful methods.
 *
 * @author    Tasos Papalyras <tasos@sht.gr>
 * @copyright 2018 SHT
 * @license   https://github.com/ShtHappens796/Core/blob/master/LICENSE MIT
 * @version   0.1.0
 * @link      https://github.com/ShtHappens796/Core
 */

// Abstract class that contains all core functions needed
abstract class Core {
    // Private datamembers
    private $root;
    private $current_page;
    protected $name;
    protected $title_separator;
    protected $patterns;
    protected $pages;
    protected $blueprints;
    // Constructor
    function __construct() {
        // Initialize private datamembers
        $this->root = $_SERVER['DOCUMENT_ROOT'];
        $this->current_page = $_SERVER['REQUEST_URI'];
        $this->name = "Core";
        $this->title_separator = "›";
        // Start the session if it wasn't already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if ($GLOBALS['debug'] === true) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
    }
    // Returns the current page URI
    function getCurrentPage() {
        return $this->current_page;
    }
    // Returns the name of the page
    function getPageName() {
        if(array_key_exists($this->getCurrentPage(), $this->pages)){
            return $this->pages[$this->getCurrentPage()];
        }
        else {
            return "404";
        }
    }
    // Returns the current page's title based on the request URI
    function getPageTitle() {
        $name = $this->getPageName();
        return $this->name . " $this->title_separator " . ucfirst($name);
    }
    // Returns the page path
    function getPagePath($page) {
        $pages_path = $this->root . "/includes/pages/";
        return $pages_path . $page . ".php";
    }
    // Get a specific page part based on a separator
    function getPageSegment($separator = null, $offset = 0) {
        $page = $this->getPageName();
        if (!$separator) {
            if (file_exists($this->getPagePath($page))) {
                require_once $this->getPagePath($page);
            }
            else {
                require_once $this->getPagePath("error404");
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
    static function initialize() {
        CORE::loadModules("/backend/core/modules");
        CORE::loadModules("/backend/shell/modules");
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
            $component_name = str_replace(".php", "", basename($component));
        }
    }
    // Returns the regular expression for the requested property
    function getPattern($pattern) {
        return $this->patterns[$pattern];
    }
    // Returns the blueprint selected for a page
    function getBlueprint($page) {
        if(array_key_exists($page, $this->blueprints)){
            return $this->blueprints[$page];
        }
        else {
            return "default";
        }
    }
    // Returns the absolute path of a blueprint
    function getBlueprintPath($page) {
        $blueprints_path = $this->root . "/includes/blueprints/";
        $blueprint = $this->getBlueprint($this->getCurrentPage());
        return $blueprints_path . $blueprint . ".php";
    }
    // Renders a page depending on a blueprint
    function loadPage() {
        $shell = $this;
        $name = $this->getPageName();
        require_once $this->getBlueprintPath($name);
    }
}
// Initialize SHT Core
CORE::initialize();
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/shell/Shell.php";
$shell->loadPage();
