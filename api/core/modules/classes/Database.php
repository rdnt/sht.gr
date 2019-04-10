<?php

class DB extends mysqli {

    // Datamember used when creating a prepared statement
    public $stmt;

    /**
     * Connects to the database server using a persistent socket if the
     * connection is not already active. If a database is specified it connects
     * To that specific database.
     *
     * @param string $host The hostname to which to connect to
     * @param string $user Database username
     * @param object $db Reference to the database connection (default: null)
     */
    function __construct($host, $user, $db = null) {
        global $core;
        // Calculate the database password path
        $pass_path = dirname($_SERVER['DOCUMENT_ROOT']) . "/db.pass";
        if (!file_exists($pass_path)) {
            // No db password file? Throw a 503 error and log it
            $core->log("DATABASE", "Missing password file");
            $core->setCurrentPage("/error/503");
            return;
        }
        // Get the db server password
        $pass = file_get_contents($pass_path);
        // Connect to the database server while suppressing warnings
        if ($db) {
            parent::__construct("p:" . $host, $user, $pass, $db);
        }
        else {
            parent::__construct("p:" . $host, $user, $pass);
        }
        if (mysqli_connect_error()) {
            // Log the errors if any
            $core->log("DATABASE", mysqli_connect_error());
            // Error during connecting to the database? Throw a 503 error
            $core->setCurrentPage("/error/503");
        }
        $this->set_charset("utf8");
    }

    /**
     * Performs a multi-query against the database and returns the status
     *
     * @param string $sql The sequence of SQL queries to perform
     * @return boolean The status of the query.
     */
    function multiQuery($sql) {
        $status = parent::multi_query($sql);
        // While there are results iterate and ignore them so that subsequent
        // queries work
        while ($this->next_result()) {
            if (!$this->more_results()) {
                break;
            }
        }
        return $status;
    }

    /**
     * Performs a query against the database and returns the result
     * @param string $sql The SQL query to perform
     * @return mixed The result of the query
     */
    function query($sql, $associative = true) {
        $response = parent::query($sql, null);
        return $this->getResults($response, $associative);
    }

    /**
     * Parses the result of the query in an appropriate format
     * @param string $response The raw response from the database server
     * @param boolean $associative Wheter the result should be returned as an
     *                             associative array or not (default: true)
     * @return mixed The result of the query:
     *               If the rows are zero, it returns false. Else, it returns an
     *               associative array containing data for each row as follows:
     *                 Based on the number of columns:
     *                  - 1: The value of the column
     *                  - 2: A key-value pair of the first column with the 2nd
     *                  - 3 or more: First row is treated as a key pointing to
     *                               an associative array containing the rest
     *                               of the columns.
     */
    function getResults($response, $associative = true) {
        if (!is_bool($response)) {
            if (mysqli_num_rows($response) != 0) {
                $data = array();
                // return all rows
                while($row = $response->fetch_assoc()) {
                    $columns = sizeof($row);
                    if (!$associative) {
                        if ($columns == 1) {
                            $data = reset($row);
                        }
                        else {
                            $data = $row;
                        }
                    }
                    else if ($columns > 2) {
                        $data[array_shift($row)] = $row;
                    }
                    else if ($columns == 2) {
                        $data[array_shift($row)] = reset($row);
                    }
                    else if ($columns == 1) {
                        $data = reset($row);
                    }
                }
                return $data;
            }
        }
        else {
            return $response;
        }
        return false;
    }

    /**
     * Parses the key that helps encrypt at-rest userdata while in the database
     * @return string The encryption key
     */
    function getEncryptionKey() {
        return file_get_contents(dirname($_SERVER['DOCUMENT_ROOT']) . "/db.key");
    }

    /**
     * Executes a prepared query
     * @return mixed The result of the query
     */
    function exec() {
        // Execute the query
        $this->stmt->execute();
        // Get the response from the database
        $response = $this->stmt->get_result();
        // Parse the result in the appropriate form
        $result = $this->getResults($response);
        // Close the prepared statement
        $this->stmt->close();
        // Return the result
        return $result;
    }

}
