<?php
// Trait that handles login
trait Github {
    // Returns the last commit from a specified branch or master
    function getLatestCommit($branch = "master") {
        $branch = $this->getRoot() . "/.git/refs/heads/$branch";
        $master = $this->getRoot() . "/.git/refs/heads/master";
        if (file_exists($branch)) {
            return substr(file_get_contents($branch), 0, 7);
        }
        else if (file_exists($master)) {
            return substr(file_get_contents($master), 0, 7);
        }
        else {
            return "unknown";
        }
    }
}
