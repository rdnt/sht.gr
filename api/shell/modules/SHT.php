<?php

trait SHT {
    function renderNav() {
        foreach ($this->pages as $page) {
            if ($page->visible) {
                $name = $page->name;
                $url = $page->url;
                $url = rtrim($url, "/") . "/";
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
}
