<?php

class IP {

    public $initialized;

    public $ip;
    public $blocked;
    public $tries;
    public $cooldown;

    function __construct($response) {
        // If response is not false, then the entry is already added for this IP
        if ($response) {
            // Entry exists;
            $this->initialized = true;
            // Get the key of the response (basically the IP int) and
            // convert it to an actual IP
            $this->ip = long2ip(key($response));
            // Get entry data
            $entry = reset($response);
            // Encode it inside the object
            $this->blocked = (int)$entry['blocked'];
            $this->tries = (int)$entry['tries'];
            $this->cooldown = $entry['cooldown'];
        }
        else {
            // New entry, initialize
            $this->initialized = false;
            $this->ip = $_SERVER['REMOTE_ADDR'];
            $this->blocked = 0;
            $this->tries = 1;
            $this->cooldown = NULL;
            // Save it
            $this->save();
        }

    }

    function reset() {
        // Unblocks the IP after the cooldown has passed
        $this->blocked = 0;
        $this->tries = 1;
        $this->save();
    }

    function block() {
        // Blocks this IP from accessing features for 5 minutes
        $this->blocked = 1;
        $this->save();
    }

    function isBlocked() {
        // Returns 1 if the IP is blocked, 0 otherwise
        return $this->blocked;
    }

    function incrementTries() {
        // Increment the tries counter
        $this->tries++;
        $this->save();
    }

    function save() {
        global $core;
        if ($this->initialized) {
            // Existing IP entry, update it with current object's properties
            $sql = "UPDATE rate_limited_ips
                    SET blocked = ?,
                        tries = ?,
                        cooldown = DATE_ADD(NOW(), INTERVAL 5 MINUTE)
                    WHERE ip = inet_aton( ? );
            ";
            return $core->query($sql, "sss", $this->blocked, $this->tries, $this->ip);
        }
        else {
            // New IP entry, initialize it in the database
            $sql = "INSERT INTO rate_limited_ips (ip)
                    VALUES ( inet_aton( ? ) );
            ";
            return $core->query($sql, "s", $this->ip);
        }


    }
}
