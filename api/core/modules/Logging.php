<?php

// Trait that handles logging
trait Logging {

    protected $logging;

    /**
     * Logs an action
     *
     * @param string $action The action to log
     * @param string $data The action data to log
     */
    function log($action, $data) {
        if ($this->options['logging']) {
            // Get the latest.log path
            $logs_folder = $this->getRoot() . "/logs/";
            $log = $logs_folder . "latest.log";
            // Add date header
            $date = date("d M Y H:i:s");
            // Create the message
            $message = $date . " $action: $data\n";
            if (file_exists($log)) {
                // Latest log exists; load it
                $data = file_get_contents($log);
                $lines = COUNT(FILE($log));
                if ($lines >= 1000) {
                    // Dump log and create a new one
                    $date = date("Ymd_His");
                    file_put_contents("$logs_folder$date.log", $data);
                    $data = $message;
                }
                else {
                    // Just append the message to existin log
                    $data .= $message;
                }
            }
            else {
                $data = $message;
            }
            // Save the latest log
            file_put_contents($log, $data);
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Deletes the logs
     */
    function purgeLogs() {
        $logs_folder = $this->getRoot() . "/logs/";
        $logs = glob("$logs_folder*.log");
        // Delete all logfiles
        foreach($logs as $log) {
            if(is_file($log)) {
                unlink($log);
            }
        }
    }

}
