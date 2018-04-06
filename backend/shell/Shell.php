<?php

class Shell extends Core {
    // Include the components
    use FormHandling;
    use Login;

    function __construct(){
        parent::__construct();
        $this->name = "SHT Core";
        $this->title_separator = "-";
        $this->patterns = array();
        $this->data_paths = array(
            "/data/"
        );
        $this->pages = array(
            "/" => "home"
        );
        $this->blueprints = array(
            "/" => "default"
        );
        $this->loadPage();
        $this->createDataPaths();
    }

}
// Initialize Shell object
$shell = new Shell;
