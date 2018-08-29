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
 * @author    Tasos Papalyras <shithappens796@gmail.com>
 * @copyright 2018 ShtHappens796
 * @license   https://github.com/ShtHappens796/Core/blob/master/LICENSE MIT
 * @version   1.0.0 (28 August 2018)
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
    protected $page;
    protected $blueprint;
    protected $content;
    protected $assets;
    protected $folders;
    protected $found;
    protected $db;
    protected $shell;
    /**
     * Constructs the shell object
     */
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
        foreach ($this->pages as $url => $page) {
            if (substr($url, 0, 1) === '#') {
                foreach ($page[3] as $inner_url => $item) {
                    if ($this->current_page === $inner_url) {
                        $this->page = $item[0];
                        $this->content = $item[1];
                        $this->blueprint = $item[2];
                        $this->found = true;
                    }
                }
            }
            else if ($this->current_page === $url) {
                $this->page = $page[0];
                $this->content = $page[1];
                $this->blueprint = $page[2];
                $this->found = true;
            }
        }
        if(!isset($_COOKIE['PHPSESSID'])) {
            $this->pushAssets();
        }
        // Start the session if it wasn't already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    /**
     * Returns the document root
     *
     * @return string The document root
     */
    function getRoot() {
        return $this->root;
    }
    /**
     * Returns the regular expression that corresponse to the input key
     *
     * @return string The regex pattern
     */
    function getPattern($pattern) {
        return $this->patterns[$pattern];
    }
    /**
     * Returns the current page path
     *
     * @return string The page path
     */
    function getCurrentPage() {
        return $this->current_page;
    }
    /**
     * Overrides the current page path
     *
     * @param string $page The page path to force
     */
    function setCurrentPage($page) {
        $this->current_page = $page;
    }
    /**
     * Returns the domain name the project is running on
     *
     * @return string Domain Name
     */
    function getDomain() {
        return $this->domain;
    }
    /**
     * Initializes the Core and loads all the files required
     */
    static function initialize() {
        CORE::loadModules("/api/core/modules");
        CORE::loadModules("/api/shell/modules");
    }
    /**
     * Loads all the modules
     *
     * @param string $path The path to recursively load the modules from
     */
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
    /**
     * Create required data paths if they don't exist
     */
    function createDataPaths() {
        foreach ($this->data_paths as $path) {
            if (!file_exists($this->root . $path)) {
                mkdir($this->root . $path);
            }
        }
    }
    /**
     * Link the database object to the core
     */
    function linkDB($db) {
        $this->db = $db;
    }
    /**
     * Redirects to a specific page and stops script execution
     *
     * @param string $page The page to redirect to
     */
    function redirect($page) {
        header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $this->getDomain() . $page);
        die();
    }
    /**
     * Returns the current page's title based on the request URI
     *
     * @return string Title
     */
    function getPageTitle() {
        return $this->title;
    }
    /**
     * Returns the current page's path based on the selected page
     *
     * @param string $page Selected page
     * @return string Page path
     */
    function getPagePath($page) {
        if ($this->found) {
            return $this->root . "/includes/pages/" . $this->content . ".php";
        }
        else {
            return $this->root . "/includes/error/404.php";
        }
    }
    /**
     * Loads a component on the page's content
     *
     * @param string $component The component to load
     */
    function loadComponent($component) {
        require_once($this->root . "/includes/components/$component.php");
    }
    /**
     * Get a specific page segment based on a separator
     *
     * @param string $separator The separator to use
     * @param string $offset The offset of the selected segment
     */
    function getPageSegment($separator = null, $offset = 0) {
        $page = $this->getCurrentPage();
        // Create a variable variable reference to the shell object
        // in order to be able to access the shell object by its name and not
        // $this when in page context
        $shell = $this->shell;
        $$shell = $this;
        if (!$separator) {
            if (file_exists($this->getPagePath($page))) {
                require_once $this->getPagePath($page);
            }
            return;
        }
        $path = $this->getPagePath($page);
        $string = file_get_contents($path);
        $segments = explode($separator, $string);
        if(array_key_exists($offset, $segments)) {
            $segment = $segments[$offset];
            if (substr($segment, 0, 5) !== "<?php") {
                $segment = "?>" . $segment;
            }
            eval($segment);
        }
    }
    /**
     * Returns the blueprint for a page
     *
     * @param string $param The selected page
     * @return string The blueprint name
     */
    function getBlueprint($page) {
        if ($this->found) {
            return $this->blueprint;
        }
        else {
            return "error";
        }
    }
    /**
     * Returns the absolute path of a blueprint
     *
     * @return string The blueprint path
     */
    function getBlueprintPath() {
        $blueprints_path = $this->root . "/includes/blueprints/";
        $blueprint = $this->getBlueprint($this->getCurrentPage());
        return $blueprints_path . $blueprint . ".php";
    }
    /**
     * Renders a page based on its blueprint's format
     */
    function renderPage() {
        $parameters = explode("/", $this->getCurrentPage());
        $folder = $parameters[1];
        if (!in_array($folder, $this->folders) && $folder !== "api") {
            $name = $this->getCurrentPage();
            require_once $this->getBlueprintPath();
        }
    }
}
// Initialize the Core
CORE::initialize();
require_once dirname(dirname(__DIR__)) . "/api/shell/Shell.php";
