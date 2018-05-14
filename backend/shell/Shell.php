<?php

class Shell extends Core {
    // Include the components
    use FormHandling;
    use Github;
    use Login;

    function __construct(){
        $this->name = "SHT Core";
        $this->title_separator = "-";
        $this->patterns = array();
        $this->data_paths = array(
            "/data/"
        );
        $this->pages = array(
            "/" => ["Home", "home", "default"]
        );
        parent::__construct();
        $this->createDataPaths();
        $this->renderPage();
    }

}
// Initialize Shell object
$shell = new Shell;
