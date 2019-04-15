<?php

function escape($string) {
    return htmlspecialchars($string);
}

function startsWith($string, $prefix) {
    if (substr($string, 0, strlen($prefix)) === $prefix) {
        return true;
    }
    return false;
}

function endsWith($string, $suffix) {
    if (substr($string, -1 * strlen($suffix)) === $suffix) {
        return true;
    }
    return false;
}

trait Strings {

    function slugify($string) {
        // replace non letter or digits by -
        $string = preg_replace('~[^\pL\d]+~u', '-', $string);
        // transliterate
        $string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);
        // remove unwanted characters
        $string = preg_replace('~[^-\w]+~', '', $string);
        // trim
        $string = trim($string, '-');
        // remove duplicate -
        $string = preg_replace('~-+~', '-', $string);
        // lowercase
        $string = strtolower($string);
        if (empty($string)) {
            return "";
        }
        return $string;
    }
}
