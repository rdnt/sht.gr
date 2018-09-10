<?php
// Trait that handles database connections and performing querries
class Database extends mysqli {
    protected $shell;
    // Connects to the database if the connection is not already active
    function __construct($shell, $host, $user, $db = null) {
        $this->shell = $shell;
        $db_pass = dirname($_SERVER['DOCUMENT_ROOT']) . "/db.pass";
        if (!file_exists($db_pass)) {
            $this->shell->log("DATABASE", "Missing password file");
            $this->shell->setCurrentPage("/error/503");
            return;
        }
        $pass = file_get_contents($db_pass);
        // Connect to the database server while suppressing warnings
        if ($db) {
            @parent::__construct("p:" . $host, $user, $pass, $db);
        }
        else {
            @parent::__construct("p:" . $host, $user, $pass);
        }
        if (mysqli_connect_error()) {
            // Log the error
            $this->shell->log("DATABASE", mysqli_connect_error());
            $this->shell->setCurrentPage("/error/503");
        }
    }
    // Performs a query against the database and returns the result
    function query($sql, $single_value = false) {
        $response = parent::query($sql);
        if (!is_bool($response)) {
            $data = array();
            // return all rows
            while($row = $response->fetch_row()) {
                $data[] = $row;
            }
            if ($single_value) {
                return $data[0][0];
            }
            return $data;
        }
        // Return boolean response
        return $response;
    }
    // Parses the password that helps encrypt userdata inside the database
    function getSecretKey() {
        return file_get_contents(dirname($_SERVER['DOCUMENT_ROOT']) . "/db.key");
    }
}
