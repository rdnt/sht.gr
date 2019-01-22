<?php

// Trait that handles logging
trait Logging {

    protected $logging;

    /**
     * Logs an action
     *
     * @param string $action The action to log
     * @param string $data The data to log
     */
    function log($action, $message) {
        // Allow from toggleable logging
        if ($this->logging) {
            // Create logs folder if it doesn't already exist
            $logs_folder = $this->getRoot() . "/logs/";
            if (!file_exists($logs_folder)) {
                mkdir($logs_folder);
            }
            // Get the latest.log path
            $log = $logs_folder . "latest.log";
            // Add date header
            $date = date("d M Y H:i:s");
            // Create the message
            $message = $date . " $action: $message" . PHP_EOL;
            if (file_exists($log)) {
                // Latest log exists; load it
                $contents = file_get_contents($log);
                $lines = COUNT(FILE($log));
                if ($lines >= 1000) {
                    // Dump log and create a new one
                    $date = date("Ymd_His");
                    file_put_contents("$logs_folder$date.log", $message);
                    $contents = $message;
                }
                else {
                    // Just append the message to existin log
                    $contents .= $message;
                }
            }
            else {
                $contents = $message;
            }
            // Save the latest log
            file_put_contents($log, $contents);
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
