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
 * @copyright 2018 Tasos Papalyras
 * @license   https://github.com/ShtHappens796/Core/blob/master/LICENSE MIT
 * @version   2.0.5 (25 October 2018)
 * @link      https://github.com/ShtHappens796/Core
 *
 */

// Abstract class that contains all core functions needed
abstract class Core {

    // Publicly accessible db object
    public $db;
    // Private inner datamembers
    private $root;
    private $project_folder;
    private $current_page;
    // Protected page data arrays
    public $pages;
    protected $patterns;
    // HTTP/2.0 Asset pushing
    protected $assets;
    protected $version;

    protected $script_queue;

    /**
     * Constructs the shell object
     */
    function __construct() {
        // Set root to be the current working directory (index.php folder)
        $this->root = str_replace("\\", "/", getcwd());
        // Compute the project subfolder relative to document root
        $project_folder = substr($this->root, strlen($_SERVER['DOCUMENT_ROOT']) );
        $this->project_folder = str_replace("\\", "/", $project_folder);
        // Set current request url
        $this->current_page = $_SERVER['REQUEST_URI'];
        // Get the code version hash
        $this->version = $this->getCommitHash();
        // Set default timezone
        date_default_timezone_set("Europe/Athens");
        // Start the session if it wasn't already started
        if (session_status() == PHP_SESSION_NONE) {
            $cookie_params = session_get_cookie_params();
            session_set_cookie_params(
                $cookie_params["lifetime"],
                $cookie_params["path"],
                '',
                $cookie_params["secure"],
                $cookie_params["httponly"]
            );
            session_name('session');
            session_start();
            if (!isset($_SESSION['csrf'])) {
                $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
            }
        }
        $this->script_queue = [];
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
     * Returns the project's folder
     *
     * @return string The project's folder
     */
    function getProjectFolder() {
        return $this->project_folder;
    }

    /**
     * Returns the current page's url
     *
     * @return string Current page's name
     */
    function getCurrentPage() {
        return $this->current_page;
    }

    /**
     * Returns the regular expression that corresponse to the input key
     *
     * @param string $type The variable type
     * @return string The regex pattern
     */
    function getPattern($type) {
        return $this->patterns[$type];
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
        $core = new RecursiveDirectoryIterator(getcwd() . $path);
        $iterator = new RecursiveIteratorIterator($core);
        $modules = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);
        // Load all modules in the directory structure recursively
        foreach ($modules as $component) {
            require_once $component[0];
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
        header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . $page);
        die();
    }

}

// Initialize the Core
CORE::initialize();
// Require the shell
require_once dirname(dirname(__DIR__)) . "/api/shell/Shell.php";
