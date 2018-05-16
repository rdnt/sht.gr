<?php
// Trait that handles logging
trait Logging {
    // Logs an action
    function log($action, $data, $origin = null) {
        // Get the latest.log path
        $logs_folder = $this->getRoot() . "/data/logs/";
        $log = $logs_folder . "latest.log";
        // Add date header
        $date = date("d M Y H:i:s");
        // Append the origin
        if ($origin) {
            $origin = " from " . $origin;
        }
        else {
            $origin = null;
        }
        // Create the message
        $message = $date . " $action: $data$origin\n";
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
    }
    // Deletes the logs
    function purgeLogs() {
        $logs_folder = $this->getRoot() . "/data/logs/";
        $logs = glob("$logs_folder*.log");
        foreach($logs as $log) {
            if(is_file($log)) {
                unlink($log);
            }
        }
    }
}
