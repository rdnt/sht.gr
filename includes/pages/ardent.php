<div class="container2">

</div>
<div class="container">
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="playlist">
        <?php for($i=1; $i<=17; $i++): ?>
            <div class="track">
                <div class="inner">
                    <div class="cover">
                        <img src="https://thumbnailer.mixcloud.com/unsafe/160x160/extaudio/5/d/0/f/3a9b-61dd-470c-96bc-a89a703ceba0">
                    </div>

                    <div class="title">
                        <span>Ardent Radio – Episode <?=$i?></span>
                    </div>
                    <div class="duration">
                        <span>1:02:15</span>
                    </div>
                    <div class="plays">
                        <span>114</span>
                    </div>
                    <div class="play-button unselectable">
                        <div class="ring">
                            <div class="center">
                                <img class="current" src="/images/play.svg">
                                <img class="current" src="/images/play.svg">
                            </div>
                            <div class="background">
                            </div>
                            <svg
                            class="progress">
                                <circle
                                class="circle"
                                stroke="white"
                                stroke-width="6"
                                fill="transparent"
                                r="17.5"
                                cx="70"
                                cy="70"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>
