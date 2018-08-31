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
    private $root;
    private $current_page;
    private $db;
    // Protected datamembers (interfacing with the Shell)
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
        $this->root = $_SERVER['DOCUMENT_ROOT'];
        $this->current_page = $_SERVER['REQUEST_URI'];
        // Set default timezone
        date_default_timezone_set("Europe/Athens");
        // If the session is not started push the assets for faster loading
        // (Depends on server configuration)
        if (!isset($_COOKIE['session'])) {
            $this->pushAssets();
        }
        // Start the session if it wasn't already started
        if (session_status() == PHP_SESSION_NONE) {
            session_name('session');
            session_start();
        }
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
    function setCurrentPage($url) {
        $data = $this->pages[$url];
        $this->current_page = $url;
        $this->page = $data[0];
        $this->content = $data[1];
        $this->blueprint = $data[2];
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
     * Loads a component on the page's content
     *
     * @param string $component The component to load
     */
    function loadComponent($component) {
        require_once($this->root . "/includes/components/$component.php");
    }
    /**
     * Renders a page based on its blueprint's format
     */
     /**
      * Inserts the main content into the page
      */
     function loadContent() {
         // Create a variable variable reference to the shell object
         // in order to be able to access the shell object by its name and not
         // $this when in page context
         $shell = $this->shell;
         $$shell = $this;
         $path = $this->root . "/includes/pages/" . $this->content . ".php";
         if (file_exists($path)) {
             require_once $path;
         }
     }
    function renderPage() {
        // Loop all pages
        foreach ($this->pages as $url => $data) {
            // If URL starts with a hash it is a dropdown and index 3 is an
            // array with the dropdown items
            if (substr($url, 0, 1) === '#') {
                foreach ($data[3] as $inner_url => $inner_data) {
                    if ($this->current_page === $inner_url) {
                        $this->page = $inner_data[0];
                        $this->content = $inner_data[1];
                        $this->blueprint = $inner_data[2];
                    }
                }
            }
            else if ($this->current_page === $url) {
                $this->page = $data[0];
                $this->content = $data[1];
                $this->blueprint = $data[2];
            }
        }
        // Acquire the first segment of the requested path
        $parameters = explode("/", $this->getCurrentPage());
        array_shift($parameters);
        $folder = $parameters[0];
        // If the page is inside a folder or is found
        if (in_array($folder, $this->folders) or !$this->page) {
            $this->setCurrentPage("/error/404");
        }
        // Format the page title
        $this->formatTitle();
        // Renders the pagecontent based on the appropriate blueprint
        $path = $this->root . "/includes/blueprints/" . $this->blueprint . ".php";
        $shell = $this;
        require_once $path;
    }
    /**
     * Redirects to a specific page and stops script execution
     *
     * @param string $page The page to redirect to
     */
    function redirect($page) {
        header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . $page);
        die();
    }
}
// Initialize the Core
CORE::initialize();
require_once dirname(dirname(__DIR__)) . "/api/shell/Shell.php";
