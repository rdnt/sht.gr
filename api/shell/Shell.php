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

    // Include required components
    use AssetPushing;
    use Date;
    use Database;
    use Encryption;
    use FormHandling;
    use Git;
    use Logging;
    use Permissions;
    use Renderer;
    use RateLimiting;

    /**
     * Shell constructor method
     */
    function __construct() {
        parent::__construct();
        $this->logging = true;
        $this->system_dirs = [
            "/.git",
            "/api/core",
            "/api/shell",
            "/less",
            "/css/internal",
            "/js/internal",
            "/includes"
        ];

        $this->app = "Core";
        $this->separator = "-";
        $this->patterns = [
            // Contains at least one uppercase letter, one lowercase letter, one number and one special character
            // Can contain any of the above
            // Length: 8-64
            'password' => '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,64}$/'
        ];

        $this->asset_dirs = [
            "/images",
            "/fonts",
            "/js",
            "/css"
        ];

        new Page("/", "Home", "home", "default");
        new Page("/test", "Home Child", "page", "default", "/");
        new Page("/page", "Page", "page", "default");
        new Page("/pageC", "Page", "pageC", "default");
        new Page("/pageB", "Page", "page", "defaultB");
        new Page("/pageCB", "Page", "pageC", "defaultB");

        new Page("/error/403", "403 Forbidden", "error/403", "error");
        new Page("/error/404", "404 Not Found", "error/404", "error");
        new Page("/error/501", "501 Not Implemented", "error/501", "error");
        new Page("/error/503", "503 Service Unavailable", "error/503", "error");

        global $pages;
        $this->pages = $pages;
        unset($pages);

        $this->assets = [
            "css/core.css" => "style"
        ];

        // Push the assets for faster loading
        // Required HTTP/2.0 to be enabled in the server configuration file
        $this->pushAssets();
        $this->formatTitle();
    }

}
// Initialize the Shell object using a variable variable
$core = new Shell();
// Initialize the connection to the database (optional) ------- |
$db = new DB('localhost', 'root', 'core'); //                   |  OPTIONAL DB
// Link the shell object with the database for easy accessing   |  CONNECTION
$core->linkDB($db); // ---------------------------------------- |
// Render the page
$core->renderPage();
