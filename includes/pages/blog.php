<div id="blog-container">
    <div id="posts">
        <div id="breadcrumbs">
            <span>
                <a href="#" class="link">Latest Posts</a>
            </span>
            <span>
                Example Post Title
            </span>
        </div>
        <? for($i=0; $i<10; $i++): ?>
            <div class="post">
                <div class="content">
                    <a href="#" class="title link">
                        abcdefghijklmnopqrstuvwxyz
                    </a>
                    <span class="date">
                        23/02/2019
                    </span>
                    <span class="description">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec in erat consectetur, facilisis quam ut, feugiat orci.
                    </span>
                </div>

                <!-- <div class="spacer" style="clear: both;"></div> -->
            </div>
        <? endfor; ?>
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
