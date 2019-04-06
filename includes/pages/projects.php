<div id="projects">
    <div class="intro">
        Here are some of the projects I've been working on
    </div>
    <div class="cards">
        <? for ($i=0; $i<25; $i++): ?>
            <? if ($i%5==0 || $i%5 == 4): ?>
                <div class="empty"></div>
            <? else: ?>
                <div class="card">
                    <img class="image" src="https://dummyimage.com/hd1080" alt="">
                    <span class="views">103 views</span>
                    <div class="inner">
                        <span class="title">Project title</span>
                        <span class="description">Project Description</span>
                        <button class="btn">VIEW MORE</button>
                    </div>
                </div>
            <? endif; ?>
        <? endfor; ?>
    </div>
</div>
