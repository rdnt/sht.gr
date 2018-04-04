<?php

class Shell extends Core {
    // Include the components
    use FormHandling;

    function __construct(){
        parent::__construct();
        $this->pages = array(
            "/" => "home",
            "/index" => "home",
            "/home" => "home"
        );
        $this->blueprints = array(
            "/" => "default",
            "/index" => "default",
        );
    }

}
// Initialize Shell object
$shell = new Shell;
