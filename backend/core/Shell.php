<?php

class Shell extends Core {
    // Include the components
    use FormHandling;

    function __construct(){
        parent::__construct();
    }

}
// Initialize Shell object
$shell = new Shell;
