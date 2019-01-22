<?php

// Trait that handles date formatting
trait Date {

    /**
     * Extracts the format of the date supplied, formats and returns it
     *
     * @param string $format The format in which the date will be formatted to
     * @param string $date The date to parse
     * @return string The formatted date string
     */
    function date($format, $date = null) {
        if ($date) {
            $date = strtotime($date);
            $date = date('Y/m/d H:i:s', $date);
            $date = $this->parseDate($date);
        }
        else {
            $now = time();
            $now = strtotime($now);
            $date = $this->parseDate($now);
        }
        return $date->format($format);
    }

    function mysql_date($date = null) {
        if (!$date) {
            return $this->date("Y-m-d H:i:s");
        }
        else {
            return $this->date("Y-m-d H:i:s", $date);
        }
    }

    function parseDate($string) {
        return new DateTime($string);
    }

}
