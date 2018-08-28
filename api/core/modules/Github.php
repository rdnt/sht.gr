<?php
// Trait that handles login
trait Github {
    /**
     * Returns the last commit hash of a branch
     *
     * @param string $branch The selected branch, defaults to master if none
     *                       specified.
     * @return string The latest commit hash
     */
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
            // Return unknown version if no valid git repository found in
            // project folder
            return "unknown";
        }
    }
}
