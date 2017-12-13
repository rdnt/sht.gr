<nav class="transparent dark">
    <div class="nav-wrapper container">
        <ul class="left hide-on-med-and-down">
        <?php

        $menuitems["/"] = "HOME";
        $menuitems["/projects.php"] = "PROJECTS";
        $menuitems["/music.php"] = "MUSIC";
        $menuitems["/about.php"] = "ABOUT";

        foreach ($menuitems as $url => $name) {
            if (strcmp($url, $_SERVER['REQUEST_URI']) === 0) {
                echo "<li><a class=\"active black-text\" href=\"$url\"><span>$name</span></a></li>";
            }
            else {
                echo "<li><a class=\"black-text\" href=\"$url\"><span>$name</span></a></li>";
            }
        }

        ?>
        </ul>



        <ul id="nav-mobile" class="sidenav">
            <li><a href="/">Home</a></li>
        </ul>
        <a href="#" data-target="nav-mobile" class="sidenav-trigger hide-on-large-only"><i class="material-icons">menu</i></a>
    </div>
</nav>
