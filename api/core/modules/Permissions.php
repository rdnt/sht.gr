<?

trait Permissions {

    function getUserID($username) {
        return $this->db->query("
            SELECT id
            FROM users
            WHERE username = '$username';
        ");
    }

    function getAccessLevel($user_id) {
        $this->db->query("
            SELECT access_level
            FROM users
            WHERE id = '$user_id';
        ");
    }

    function setAccessLevel($username) {
        $user_id = $this->getUserID($username);
        if ($this->db) {
            $access_level = $this->getAccessLevel($user_id);
            $_SESSION['access_level'] = $access_level;
        };
    }

    function loggedIn() {
        if (isset($_SESSION['login'])) {
            return $_SESSION['login'];
        }
        return false;
    }

    function isAccessible($location) {

        $accessible = true;
        foreach ($this->system_dirs as $path) {
            if (substr($location, 0, strlen($path)) === $path) {
                $accessible = false;
            }
        }
        if ($accessible) {
            return true;
        }
        else {
            return false;
        }
    }


    function canAccess($location) {
        return true;
        // $protected = $this->protected_paths;
        // $private = $this->private_paths;
        //
        // $levels = true;
        // foreach ($protected as $key => $value) {
        //     if (is_int($key)) {
        //         $levels = false;
        //         // Logged in check only
        //         if ($this->loggedIn()) {
        //             // Allow protected resource
        //             unset($protected[$key]);
        //         }
        //     }
        //     else {
        //         // A minimum access level is set
        //         if (0 <= $access_level && $access_level <= $value) {
        //             // Allow protected resource
        //             unset($protected[$key]);
        //         }
        //     }
        // }
        //
        // if ($levels) {
        //     // Permission levels are used and not logged in state
        //     // Move values on the protected fields
        //     $protected = array_keys($protected);
        // }
        //
        // $secured = array_merge($private, $protected);
        //
        //
        // $allowed = true;
        // if ($location == "/") {
        //     return true;
        // }
        // foreach ($secured as $path) {
        //     if (
        //         substr($location, 0, strlen($path)) === $path
        //     ) {
        //         $allowed = false;
        //     }
        // }
        // if (substr($location, -1) == "/") {
        //     return false;
        // }
        // if ($allowed) {
        //     return true;
        //     echo "ALLOWED";
        // }
        // return false;
    }


}
