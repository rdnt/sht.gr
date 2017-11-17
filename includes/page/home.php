<style>
#loader {
    position: absolute;
    height: 100%;
    width: 100%;
    background-color: #0a0b0c;
}

#loader .wrapper {
    position: absolute;
    height: 89px;
    width: 89px;
    left: calc(50% - 44.5px);
    top: calc(50% - 44.5px);
    animation: init .5s ease-out, load 1s infinite .5s cubic-bezier(0,.5,.5,1) alternate;
    position: fixed;
}

@keyframes load {
    0% {
        transform: scale(1);
    }
    100% {
        transform: scale(1.1);
    }
}

@keyframes init {
    0% {
        transform: scale(200);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

#loader .wrapper .right-triangle {
    border-style: solid;
    border-width: 0 25px 43.3px 25px;
    border-color: transparent transparent #ffffff transparent;
    transform: rotate(45deg);
    right: 0px;
    position: absolute;
    top: 10px;
}

#loader .wrapper .left-triangle {
    border-style: solid;
    border-width: 0 25px 43.3px 25px;
    border-color: transparent transparent #ffffff transparent;
    transform: rotate(225deg);
    left: 0px;
    position: absolute;
    top: 38px;
}
</style>
<div id="loader">
    <div class="wrapper">
        <div class="right-triangle"></div>
        <div class="left-triangle"></div>
    </div>
</div>

<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d9/Big_Bear_Valley%2C_California.jpg/1200px-Big_Bear_Valley%2C_California.jpg">
