<div id="blog-container" class="container">
    <div id="posts">
        <div id="breadcrumbs">
            <span>
                <a href="#" class="link">Latest Posts</a>
            </span>
            <span>
                Example Post Title
            </span>
        </div>
        <? foreach ($core->getPosts() as $post):?>
            <div class="post">
                <div class="content">
                    <span class="date">
                        <?= date('d/m/Y', $post->timestamp) ?>
                    </span>
                    <a href="#" class="title link">
                        <?=$post->title?>
                    </a>
                    <span class="description">
                        <?=$post->description?>
                    </span>
                </div>
            </div>
        <? endforeach; ?>
        <? $core->loadComponent("pagination"); ?>
    </div>
</div>
