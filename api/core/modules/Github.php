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
    function getLatestCommit($branch = "master", $length = 0) {
        $branch = $this->getRoot() . "/.git/refs/heads/$branch";
        $master = $this->getRoot() . "/.git/refs/heads/master";
        if (file_exists($branch)) {
            $head = file_get_contents($branch);
        }
        else if (file_exists($master)) {
            $head = file_get_contents($master);
        }
        if ($head) {
            if ($length) {
                return substr($head, 0, $length);
            }
            else {
                return $head;
            }
        }
        else {
            return;
        }
    }
}
