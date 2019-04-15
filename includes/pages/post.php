<? $post = $core->getCurrentPost() ?>
<div id="post-container" class="container">
    <div id="post">

        <div class="post">
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
                <div class="code-block">
                    <div class="lang">PHP</div>
                    <div class="copy">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M18 6v-6h-18v18h6v6h18v-18h-6zm-12 10h-4v-14h14v4h-10v10zm16 6h-14v-14h14v14z"/></svg>
                    </div>
                    <?=$post->content?>
                </div>
            </span>
        </div>
    </div>
</div>
