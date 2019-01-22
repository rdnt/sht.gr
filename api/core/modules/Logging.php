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
        if ($logging) {
            // Create logs folder if it doesn't already exist
            $logs_folder = $this->getRoot() . "/logs/";
            if (!file_exists($logs_folder)) {
                mkdir($logs_folder);
            }
            if ($this->options['logging']) {
                // Get the latest.log path
                $log = $logs_folder . "latest.log";
                // Add date header
                $date = date("d M Y H:i:s");
                // Create the message
                $message = $date . " $action: $message\n";
                if (file_exists($log)) {
                    // Latest log exists; load it
                    $message = file_get_contents($log);
                    $lines = COUNT(FILE($log));
                    if ($lines >= 1000) {
                        // Dump log and create a new one
                        $date = date("Ymd_His");
                        file_put_contents("$logs_folder$date.log", $message);
                        $message = $message;
                    }
                    else {
                        // Just append the message to existin log
                        $message .= $message;
                    }
                }
                else {
                    $message = $message;
                }
                // Save the latest log
                file_put_contents($log, $message);
            }
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
