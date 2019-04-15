<!-- <div class="theme-overlay"></div> -->
<div id="navigation">
    <a class="logo" href="/">
        <img src="/images/logo.svg" alt="">
    </a>
    <nav>
        <ul class="navigation">
            <? foreach ($core->pages as $page): ?>
                <? if ($page->visible): ?>
                    <li class="<?= $page->current ? "active" : "" ?>"><a href="<?=$page->url?>"><span><?=$page->name?></span></a></li>
                <? endif; ?>
            <? endforeach; ?>
        </ul>
    </nav>
</div>
