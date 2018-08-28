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
    function __construct(){
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
        $this->folders = array(
            "css",
            "js",
            "data"
        );
        $this->assets = array(
            "/css/core.css" => "style"
        );
        parent::__construct();
        $this->pushAssets();
        $this->title = $this->name . " $this->title_separator " . $this->page;
        if (!$this->found) {
            $this->title = $this->name . " $this->title_separator " . "Error 404";
        }
        $this->createDataPaths();
        $this->renderPage();
    }
}
// Initialize the Shell object
$shell = new Shell;
