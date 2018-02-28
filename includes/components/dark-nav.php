<nav class="transparent dark">
    <div class="nav-wrapper container">
        <ul class="left hide-on-med-and-down">
        <?php

        $menuitems["/"] = "HOME";
        //$menuitems["/posts"] = "POSTS";
        //$menuitems["/projects"] = "PROJECTS";
        //$menuitems["/music"] = "MUSIC";
        //$menuitems["/about"] = "ABOUT";

        foreach ($menuitems as $url => $name) {
            if (strcmp($url, $_SERVER['REQUEST_URI']) === 0) {
                echo "<li><a class=\"active\" href=\"$url\"><span>$name</span></a></li>";
            }
            else {
                echo "<li><a href=\"$url\"><span>$name</span></a></li>";
            }
        }

        ?>
        </ul>
        <ul class="right reverse-nav">
        <?php
        if (isset($_SESSION['login'])) {
            $login = $_SESSION['login'];
            echo "<li><a href=\"#\"><span>Logged in as $login</span></a></li>";
        }
        else {
            echo "<li><a href=\"/login\"><span>LOGIN</span></a></li>";
        }
        ?>
        </ul>

        <ul id="nav-mobile" class="sidenav">
            <li><a href="/">Home</a></li>
        </ul>
        <a href="#" data-target="nav-mobile" class="sidenav-trigger hide-on-large-only"><i class="material-icons">menu</i></a>
    </div>
</nav>
<div class="nav-background sht-depth-2"></div>
