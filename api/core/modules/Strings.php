<?php

function escape($string) {
    return htmlspecialchars($string);
}

function startsWith($string, $prefix) {
    if (substr($string, 0, strlen($suffix)) === $suffix) {
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
