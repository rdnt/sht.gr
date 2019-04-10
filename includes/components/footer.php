<? if ($core->current_page == "/"): $footer_class = "light"; $link_class = ""; else: $footer_class = ""; $link_class = "light"; endif; ?>
<footer class="section <?=$footer_class?>">
    <div class="container">
        <div class="source segment">
            <div class="title">
                Source
            </div>
            <div class="details">
                The source code of my website is available on <a class="link <?=$link_class?>" href="https://github.com/SHT/sht.gr" target="_blank">GitHub</a>.
            </div>
        </div>
        <div class="social segment">
            <div class="title">
                Social
            </div>
            <? $core->loadComponent("social-icons"); ?>
        </div>
        <div class="sitemap segment">
            <div class="title">
                Sitemap
            </div>
            <ul class="page-sitemap">
                <? foreach ($this->pages as $page): ?>
                    <? if ($page->visible): ?>
                        <li><a class="link <?=$link_class?>" href="<?=$page->url?>"><?=$page->name?></a></li>
                    <? endif; ?>
                <? endforeach; ?>
            </ul>
        </div>
    </div>
</footer>
