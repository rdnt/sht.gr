<?php

class Shell extends Core {
    // Include the components
    use AssetPushing;
    use FormHandling;
    use Github;
    use Logging;
    use Login;
    // Shell constructor method
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
        $this->assets = array();
        parent::__construct();
        $this->createDataPaths();
        $this->renderPage();
    }
}
// Initialize Shell object
$shell = new Shell;
