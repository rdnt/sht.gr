<?php

// Trait that handles rate limiting
trait RateLimiting {

    /**
     * Applies rate limiting to an operation (requires a database connection)
     */
    function apply_rate_limiting($action) {
        // Get the remote IP address
        $ip = $_SERVER['REMOTE_ADDR'];
        // Query the database for this IP
        $sql = "SELECT ip, blocked, tries, UNIX_TIMESTAMP(cooldown) AS cooldown
                FROM rate_limited_ips
                WHERE ip = inet_aton( ? );
        ";
        $response = $this->query($sql, "s", $ip);
        // Initialize a new IP object
        $rlip = new IP($response);
        // Existing entry
        if ($response) {
            // Check the tries counter
            if ($rlip->tries < 5 - 1) {
                // Still got tries, just increment
                $rlip->incrementTries();
            }
            else {
                // IP doesn't have more tries! Is it blocked?
                if ($rlip->isBlocked()) {
                    // It is indeed blocked
                    $now = $this->date("U");
                    // Check if it should be unblocked
                    if ($now < $rlip->cooldown) {
                        // Oops, still blocked, disregard request
                        $this->response("RATE_LIMITED");
                    }
                    else {
                        // Unblocked! Reset it
                        $rlip->reset();
                    }
                }
                else {
                    // IP should be blocked but is not! Block it!
                    $rlip->block();
                    $this->log("RATE-LIMIT", "Action $action is being rate-limited for $ip");
                }
            }
        }
    }

    /**
     * Resets the rate limiting counter if a request was successful
     */
    function reset_rate_limiting() {
        // Get the remote IP address
        $ip = $_SERVER['REMOTE_ADDR'];
        // Delete the entry for this IP
        $sql = "DELETE
                FROM rate_limited_ips
                WHERE ip = inet_aton( ? );
        ";
        $this->query($sql, "s", $ip);
    }

}
