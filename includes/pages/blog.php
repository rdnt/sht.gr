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
        <div id="pagination">
            <a href="#" class="start"></a>
            <a href="#" class="prev"></a>

            <a href="#" class="active page">1</a>
            <a href="#" class="page">2</a>
            <a href="#" class="page">3</a>
            <div class="spacer">•••</div>
            <a href="#" class="page">23</a>

            <a href="#" class="next"></a>
            <a href="#" class="end"></a>
        </div>
    </div>

</div>
