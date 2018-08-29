<?php
// Trait that handles database connections and performing querries
class Database extends mysqli {
    protected $shell;
    // Connects to the database if the connection is not already active
    function __construct($host, $user, $db = null) {
        $pass = file_get_contents(dirname($_SERVER['DOCUMENT_ROOT']) . "/db.pass");
        // Connect to the database server while suppressing warnings
        if ($db) {
            @parent::__construct("p:" . $host, $user, $pass, $db);
        }
        else {
            @parent::__construct("p:" . $host, $user, $pass);
        }

        if (mysqli_connect_error()) {
            // Log the error
            $shell = new Shell();
            $shell->log("DATABASE", mysqli_connect_errno() . " - " . mysqli_connect_error());
            die();
        }
    }
    // Performs a query against the database and returns the result
    function query($sql) {
        $response = parent::query($sql);
        if (!is_bool($response)) {
            $data = array();
            // return all rows
            while($row = $response->fetch_row()) {
                $data[] = $row;
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
