<?php

// Trait that handles database connections and performing querries
class Database extends mysqli {

    protected $shell;
    private $host;
    private $user;
    private $db;
    private $pass;

    /**
     * Connects to the database using a persistent socket if the connection
     * is not already active
     *
     * @param string $shell The shell object
     * @param string $host The hostname to which to connect to
     * @param string $user Database username
     * @param string $db Reference to the database connection
     */
    function __construct($shell, $host, $user, $db = null) {

        $this->shell = $shell;

        $this->host = $host;
        $this->user = $user;
        $this->db = $db;

        $db_pass = dirname($_SERVER['DOCUMENT_ROOT']) . "/db.pass";
        if (!file_exists($db_pass)) {
            $this->shell->log("DATABASE", "Missing password file");
            $this->shell->setCurrentPage("/error/503");
            return;
        }
        $this->pass = file_get_contents($db_pass);

        $this->connect($this->host, $this->user, $this->pass, $this->db);
    }

    function connect($host = NULL, $user = NULL, $password = NULL, $database = NULL, $port = NULL, $socket = NULL) {

        // Connect to the database server while suppressing warnings
        if ($this->db) {
            @parent::__construct("p:" . $this->host, $this->user, $this->pass, $this->db);
        }
        else {
            @parent::__construct("p:" . $this->host, $this->user, $this->pass);
        }
        $this->shell->log("DATABASE", "All Good");
        if (mysqli_connect_error()) {
            // Log the error
            $this->shell->log("DATABASE", mysqli_connect_error());
            $this->shell->setCurrentPage("/error/503");
        }
    }

    function recreateDB($db) {
        $this->close();
        $this->connect($this->host, $this->user, $this->pass);
        $this->query("
            DROP DATABASE $db;
        ");
        $this->query("
            CREATE DATABASE $db;
        ");
        $this->close();
        $this->connect($this->host, $this->user, $this->pass, $db);
    }

    function multi_query($sql) {
        $status = parent::multi_query($sql);
        while ($this->next_result()) {
            if (!$this->more_results()) {
                break;
            }
        }
        return $status;
    }

    /**
     * Performs a query against the database and returns the result
     *
     * @param string $sql The sql query
     */
    function query($sql, $resultmode = NULL) {
        $response = parent::query($sql, $resultmode);
        return $this->processResponse($response);
    }

    function processResponse($response) {
        if (!is_bool($response)) {
            if (mysqli_num_rows($response) != 0) {
                $data = array();
                // return all rows
                while($row = $response->fetch_assoc()) {
                    if (sizeof($row) > 2) {
                        $data[array_shift($row)] = $row;
                    }
                    else if (sizeof($row) == 2) {
                        $data[array_shift($row)] = reset($row);
                    }
                    else if (sizeof($row) == 1) {
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
     * Parses the password that helps encrypt userdata inside the database
     *
     * @return string The password for the specified database user
     */
    function getSecretKey() {
        return file_get_contents(dirname($_SERVER['DOCUMENT_ROOT']) . "/db.key");
    }

}
