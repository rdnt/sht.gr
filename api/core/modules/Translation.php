<?php

function __($text, $domain = "default") {
    translate($text, $domain);
}

function translate($text, $domain = "default") {
    global $core;
    $lang = $core->getLang();
    $sql = "SELECT value
            FROM strings
            WHERE string = ?
            AND lang = ?
            AND domain = ?;
    ";
    $response = $core->query($sql, "sss", $text, $lang, $domain);
    if ($response) {
        echo $response;
    }
    else {
        echo $text;
    }
}

trait Translation {

    protected $lang;

    function getLang() {
        return $this->lang;
    }

}
