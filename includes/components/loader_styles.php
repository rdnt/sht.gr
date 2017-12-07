<style>
body {
    margin: 0;
    overflow-x: hidden;
}
#loader {
    top: 0;
    position: absolute;
    height: 100%;
    width: 100%;
    background-color: #0a0b0c;
    overflow: hidden;
    z-index: 1000;
}

.slide-right {
    animation: slide-in 1s cubic-bezier(0,.5,.5,1), maintain-center .1s 1s linear, slide-right 1.5s 1.1s cubic-bezier(1,0,0,1);
    transform: translateX(75%);
}

.slide-left {
    animation: slide-in 1s cubic-bezier(0,.5,.5,1), maintain-center .1s 1s linear, slide-left 1.5s 1.1s cubic-bezier(1,0,0,1);
    transform: translateX(-125%);
}

.init-right {
    transform: translateX(calc(100px - 25%));
}

.init-left {
    transform: translateX(calc(-100px - 25%));
}

#loader #right-panel {
    position: absolute;
    height: 100%;
    width: 200%;
    background: -webkit-linear-gradient(225deg, #0a0b0c 50.1%, rgba(0,0,0,0) 50.1%);
    z-index: 2000;
    opacity: 1000;
}

#loader #left-panel {
    position: absolute;
    height: 100%;
    width: 200%;
    background: -webkit-linear-gradient(225deg, rgba(0,0,0,0) 49.9%, #0a0b0c 49.9%);
    z-index: 2000;
    opacity: 1;
}

.invisible {
    opacity: 0;
}

.display-none {
    display: none;
}

.transparent {
    background-color: transparent;
}

#loader #logo-wrapper {
    position: absolute;
    height: 89px;
    width: 89px;
    left: calc(50% - 43px);
    top: calc(50% - 44.5px);
    animation: load 1.5s infinite cubic-bezier(0,.5,.5,1) alternate;
    z-index: 1000;
}

@keyframes load {
    0% {
        transform: scale(1);
    }
    100% {
        transform: scale(1.1);
    }
}

@keyframes maintain-center {
    0% {
        transform: translateX(-25%);
    }
    100% {
        transform: translateX(-25%);
    }
}

@keyframes slide-right {
    0% {
        transform: translateX(-25%);
        opacity: 1;
    }
    100% {
        transform: translateX(75%);
        opacity: 1;
    }
}

@keyframes slide-left {
    0% {
        transform: translateX(-25%);
        opacity: 1;
    }
    100% {
        transform: translateX(-125%);
        opacity: 1;
    }
}

@keyframes slide-in {
    0% {
        opacity: 1;
    }
    100% {
        transform: translateX(-25%);
        opacity: 1;
    }
}

#loader #logo-wrapper .right-triangle {
    border-style: solid;
    border-width: 0 25px 43.3px 25px;
    border-color: transparent transparent #ffffff transparent;
    transform: rotate(45deg);
    right: 0px;
    position: absolute;
    top: 10px;
}

#loader #logo-wrapper .left-triangle {
    border-style: solid;
    border-width: 0 25px 43.3px 25px;
    border-color: transparent transparent #ffffff transparent;
    transform: rotate(225deg);
    left: 0px;
    position: absolute;
    top: 38px;
}
</style>
