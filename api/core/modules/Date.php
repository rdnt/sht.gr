<?php

// Trait that handles date formatting
trait Date {

    /**
     * Extracts the format of the date supplied, formats and returns it
     *
     * @param string $date The date to parse
     * @param string $format The format in which the date will be formatted to
     * @return string The formatted date string
     */
    function date($date, $format) {
        $date = strtotime($date);
        return date($format, $date);
    }

}
