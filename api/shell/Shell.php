<?php
/**
 * Shell Class
 *
 * The Shell extends the Core and is the class that initializes any
 * project-specific datamembers along with defining the rendering logic of
 * each page. An object of the shell class allows for ease-of-access
 * of core functions or module-related functions.
 *
 */
class Shell extends Core {
    // Include the components
    use AssetPushing;
    use Encryption;
    use FormHandling;
    use Github;
    use Logging;
    /**
     * Shell constructor method
     */
    function __construct($shell = null) {
        parent::__construct();
        $this->shell = $shell;
        $this->name = "Core";
        $this->title_separator = "-";
        $this->patterns = array();
        $this->data_paths = array(
            "/data/",
            "/data/logs/"
        );
        $this->pages = array(
            "/" => ["Home", "home", "default"]
        );
        $this->errors = array(
            "/error/404" => ["404 Not Found", "error/404", "error"],
            "/error/503" => ["503 Service Unavailable", "error/503", "error"]
        );
        $this->pages = array_merge($this->pages, $this->errors);
        $this->folders = array(
            "api",
            "css",
            "js",
            "data"
        );
        $this->assets = array(
            "/css/core.css" => "style"
        );
        $this->pushAssets();
        $this->createDataPaths();
    }
    /**
     * Formats the title
     */
    function formatTitle() {
        $this->title = $this->name . " $this->title_separator " . $this->page;
    }
}
// Set the shell object name (for accessing in page segments and APIs)
$shell = "core";
// Initialize the Shell object using a variable variable
$$shell = new Shell($shell);
// Initialize the connection to the database (optional) ------- |
$db = new Database($$shell, 'localhost', 'root', $shell); //    |  OPTIONAL DB
// Link the shell object with the database for easy accessing   |  CONNECTION
$$shell->linkDB($db); // -------------------------------------- |
// Render the page
$$shell->renderPage();
