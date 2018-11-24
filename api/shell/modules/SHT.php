<?php
trait SHT {
    function renderNav() {
        foreach ($this->pages as $url => $data) {
            $name = strtoupper($data[0]);
            if ($url === $_SERVER['REQUEST_URI']) {
                $active = " class=\"active\"";
            }
            else {
                $active = "";
            }
            echo "<li$active><a href=\"$url\"><span>$name</span></a></li>\n";
        }
    }
}
