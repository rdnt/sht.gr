<?php
trait SHT {
    function renderNav() {
        foreach ($this->pages as $url => $data) {
            $name = strtoupper($data[0]);
            if (substr($url, 0, 1) === '#') {
                echo "<div class=\"dropdown\">\n";
                echo "<li><a><span>$name</span></a></li>\n";
                foreach ($data[3] as $inner_url => $item) {
                    $inner_name = strtoupper($item[0]);
                    if ($inner_url === $this->getCurrentPage()) {
                        $active = " active";
                    }
                    else {
                        $active = "";
                    }
                    echo "<li class=\"item$active\"><a href=\"$inner_url\"><span>$inner_name</span></a></li>\n";
                }
                echo "</div>\n";
            }
            else {
                $name = strtoupper($data[0]);
                if ($url === $this->getCurrentPage()) {
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
