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
 * @version   2.0.0 (25 October 2018)
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
    // Protected title-related datamembers
    protected $name;
    protected $separator;
    protected $title;
    // Private page rendering datamembers
    private $page;
    private $blueprint;
    private $content;
    // Protected page data arrays
    protected $pages;
    protected $patterns;
    protected $assets;
    protected $data_paths;

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
        // Set default timezone
        date_default_timezone_set("Europe/Athens");
        // If the session is not started push the assets for faster loading
        // (Depends on server configuration)
        if (!isset($_COOKIE['version'])) {
            $this->pushAssets();
        }
        // Start the session if it wasn't already started
        if (session_status() == PHP_SESSION_NONE) {
            session_name('session');
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
     * Returns the current page's name
     *
     * @return string Current page's name
     */
    function getPage() {
        return $this->page;
    }

    /**
     * Formats the current page's title
     */
    function formatTitle() {
        $this->title = $this->name . " " . $this->separator . " " . $this->page;
    }

    /**
     * Overrides the current page path
     *
     * @param string $page The page path to force
     */
    function setCurrentPage($url) {
        $pages = array_merge($this->pages, $this->errors);
        $data = $pages[$url];
        $this->current_page = $url;
        $this->page = $data[0];
        $this->content = $data[1];
        $this->blueprint = $data[2];
        // Re-format the title since the page data was changed
        $this->formatTitle();
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
        foreach ($modules as $component => $filename) {
            require_once $component;
        }
    }

    /**
     * Link the database object to the core
     */
    function linkDB($db) {
        $this->db = $db;
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
     * Renders a page based on its blueprint's format
     */
    function renderPage() {
        // Loop all pages
        $folder = $this->project_folder;
        if ($folder) {
            $folder = "/" . $folder;
        }
        $pages = array_merge($this->pages, $this->errors);
        foreach ($pages as $url => $data) {
            // If URL starts with a hash it is a dropdown and index 3 is an
            // array with the dropdown items
            if (substr($folder . $url, 0, 1) === '#') {
                foreach ($data[3] as $inner_url => $inner_data) {
                    if ($this->current_page === $inner_url) {
                        $this->page = $inner_data[0];
                        $this->content = $inner_data[1];
                        $this->blueprint = $inner_data[2];
                    }
                }
            }
            else if ($this->current_page === $folder . $url) {
                $this->page = $data[0];
                $this->content = $data[1];
                $this->blueprint = $data[2];
            }
        }
        // Acquire the first segment of the requested path
        $dir = substr($this->root, strlen($_SERVER['DOCUMENT_ROOT']));
        $current_page = substr($this->current_page, strlen($dir));
        $parameters = explode("/", $current_page);
        array_shift($parameters);
        $folder = $dir . "/" . $parameters[0];

        $this->formatTitle();
        if ($parameters[0] == "api") {
            $path = $this->root . $current_page . ".php";
            if (file_exists($path)) {
                $shell = $this->shell;
                $$shell = $this;
                require_once $path;
            }
            else {
                $this->setCurrentPage("/error/404");
                $path = $this->root . "/includes/blueprints/" . $this->blueprint . ".php";
                $shell = $this->shell;
                $$shell = $this;
                require_once $path;
            }
        }
        else {
            if (!$this->page) {
                $this->setCurrentPage("/error/404");
            }
            $path = $this->root . "/includes/blueprints/" . $this->blueprint . ".php";
            $shell = $this->shell;
            $$shell = $this;
            require_once $path;
        }
    }

    /**
     * Loads a component on the page's content
     *
     * @param string $component The component to load
     */
    function loadComponent($component) {
        $shell = $this->shell;
        $$shell = $this;
        require_once($this->root . "/includes/components/$component.php");
    }

    /**
     * Inserts the main content into the page
     */
    function loadContent($index = -1) {
        // Create a variable variable reference to the shell object
        // in order to be able to access the shell object by its name and not
        // $this when in page context
        $shell = $this->shell;
        $$shell = $this;
        $path = $this->root . "/includes/pages/" . $this->content . ".php";
        if (file_exists($path)) {
            if ($index != -1) {
                $page = file_get_contents($path);
                $segments = explode("<!--- SCRIPTS --->", $page);
                if(array_key_exists($index, $segments)) {
                    $segment = $segments[$index];
                    if (substr($segment, 0, 5) !== "<?") {
                        $segment = "?>" . $segment;
                    }
                    eval($segment);
                }
                return;
            }
            require_once $path;
        }
    }

    /**
     * Returns a formatted style include
     *
     * @param string $style The style filename
     * @return string The link tag
     */
    function loadStyle($style) {
        $project_dir = $this->project_folder;
        $commit_hash = $this->getLatestCommit();
        return "<link href=\"$project_dir/css/$style?v=$commit_hash\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\"/>\n";
    }

    /**
     * Returns a formatted script tag
     *
     * @param string $script The script filename
     * @return string The script tag
     */
    function loadScript($script) {
        $project_dir = $this->project_folder;
        $commit_hash = $this->getLatestCommit();
        return "<script src=\"$project_dir/js/$script?v=$commit_hash\"></script>\n";
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
