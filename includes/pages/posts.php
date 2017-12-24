<div class="container">
    <div class="row">
        <div class="posts col l8 m12 s12">
            <?php
            $posts_dir = $_SERVER['DOCUMENT_ROOT']."/data/posts/";
            $it    = new DirectoryIterator($posts_dir);
            $posts = array();
            $dates = array();

            foreach ($it as $fileinfo) {
                if (!$fileinfo->isDot() and $fileinfo->getExtension() == "json") {

                    $slug = $fileinfo->getBasename(".json");

                    $post = POST::decode($posts_dir . "$slug.json");
                    $posts[] = $post;

                    $dates[] = $post->getDateCreated();
                }
            }
            usort($posts, array("POST", "compare"));

            $posts = array_slice($posts, 0, 10);

            ?>
            <?php

            foreach($posts as $post) {

                $title = $post->getTitle();
                $date = $post->printDate("Ymd_His", "F d, Y - H:i");
                $content = $post->getContent();

                echo<<<HEREDOC

                <div class="post sht-depth-3">
                    <div class="title">
                        $title
                    </div>
                    <div class="date">
                        Posted in $date
                    </div>
                    <div class="divider"></div>
                    <div class="content">
                        $content
                    </div>
                    <div class="read-more-btn">
                        <a href="#">
                            read more
                            <img src="images/home/arrow_down_black.svg">
                        </a>
                    </div>
                </div>

HEREDOC;
            }

            ?>

        </div>
        <div class="col l4 m12 s12">
            <div class="sidebar sht-depth-3">
                <div class="content">
                    Sidebar
                </div>
            </div>
        </div>
    </div>
</div>
