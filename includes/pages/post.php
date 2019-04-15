<? $post = $core->getCurrentPost() ?>
<?php

// $data = array(
//     "title" => "Post r",
//     "description" => "Post r description",
//     "content" => "<code lang=\"twig\">{{ HTML }}</code>"
// );
// $post2 = $core->newPost($data);

?>
<div id="post-container" class="container">
    <div id="post">
        <div id="breadcrumbs">
            <span>
                <a href="/blog" class="link">Latest Posts</a>
            </span>
            <span>
                <?= $post->title ?>
            </span>
        </div>
        <span class="date">
            <?= date('d/m/Y', $post->timestamp) ?>
        </span>
        <div class="title">
            <?=$post->title?> An hoc usque quaque, aliter in vita? How to Make Powerful Connections by Writing Unexpected Thank You Emails
        </div>
        <div class="description">
            <?=$post->description?> Post 0 An hoc usque quaque, aliter in vita? How to Make Powerful Connections by Writing Unexpected Thank You Emails Powerful Connections by Writing Unexpected Thank You Emails Powerful Connections by Writing Unexpected Thank You Emails Powerful Connections by Writing Unexpected Thank You Emails
        </div>
        <span class="content">
            <?=$post->content?>
        </span>
    </div>
</div>
