<!-- <div class="theme-overlay"></div> -->
<div id="navigation">
    <a class="logo" href="/">
        <!-- <div class="inner"></div> -->
        <img src="/images/logo.svg" alt="">
    </a>
    <nav>
        <ul class="navigation">
            <? foreach ($core->pages as $page): ?>
                <? if ($page->visible): ?>
                    <?php
                        if ($page->url === $core->getCurrentPage()) {
                            $active = "active";
                        }
                        else {
                            $active = "";
                        }
                    ?>
                    <li class="<?=$active?>"><a href="<?=$page->url?>"><span><?=$page->name?></span></a></li>
                <? endif; ?>
            <? endforeach; ?>
        </ul>
    </nav>
</div>
