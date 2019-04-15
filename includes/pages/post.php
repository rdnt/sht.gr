<? $post = $core->getCurrentPost() ?>
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
        <div class="post">
            <span class="date">
                <?= date('d/m/Y', $post->timestamp) ?>
            </span>
            <a href="/blog/post/<?=$post->slug?>" class="title link">
                <?=$post->title?>
            </a>
            <span class="description">
                <?=$post->description?>
            </span>
            <span class="content">
                <?=$post->content?>
            </span>
        </div>
    </div>
</div>
