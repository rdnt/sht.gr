<?php

trait Database {

    function multiQuery($sql) {
        return $this->db->multiQuery($sql);
    }

    function query($sql, $format = null, &...$args) {
        $this->prepare($sql);
        if ($format) {
            $this->bind($format, ...$args);
        }
        return $this->exec();
    }

    function prepare($sql) {
        $this->db->stmt = $this->db->prepare($sql);
    }

    function bind($format, &...$args) {
        // Initialize parameters array with the format
        $params = array($format);
        // Add all the variable references to the array (+1 because 0 is format)
        foreach($args as $key => &$value) {
            $params[$key+1] = &$args[$key];
        }
        // Call the bind_param function on the stmt and pass it the params
        call_user_func_array(array($this->db->stmt, 'bind_param'), $params);
    }

    function exec() {
        return $this->db->exec();
    }
}
