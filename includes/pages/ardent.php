<div class="page-header">
    <img src="/images/ardent_white.png">
</div>
<div class="playlist">
    <div class="header">
        <div class="inner">
            <div class="spacer"></div>
            <div class="title">
                <span>Title</span>
            </div>
            <div class="duration">
                <span>Duration</span>
            </div>
            <div class="plays">
                <span>Plays</span>
            </div>
        </div>
    </div>
    <?php for($i=1; $i<=17; $i++): ?>
        <div class="track" data-ep="<?=$i?>">
            <div class="inner">
                <div class="button play"></div>
                <div class="title">
                    <span>Ardent Radio – Episode <?=str_pad($i, 2, 0, STR_PAD_LEFT)?></span>
                </div>
                <div class="duration">
                    <span>1:02:15</span>
                </div>
                <div class="plays">
                    <span>114</span>
                </div>
            </div>
        </div>
    <?php endfor; ?>
</div>
