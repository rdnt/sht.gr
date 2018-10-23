Home
<style>

.carousel {
  position: relative;
  width: 100%;
  height: 800px;
  overflow: hidden;
}
.clear {
  position: absolute;
  border: none !important;
}
.img {
  margin-left: -120px;
  position: absolute;
  width: 1000px;
  height: 800px;
  overflow: hidden;
  display: inline-block;
  transform: skew(-15deg);
  border-left: 5px solid #0a0b0c;
  transition: transform .5s ease;
}
.img:first-child {
  width: 1500px;
}
.img.load {
  display: none;
}
.img .clear {
  position: relative;
  height: 800px;
  background-color: #0a0b0c;
  pointer-events: none;
}
.img.active {
  background: #f0f !important;
}
.img.active img {
  transform: skew(15deg) translateX(-120px);
  z-index: 10;
}
.img img {
  height: 101%;
  transform: skew(15deg) translateX(-100px);
  transition: transform .5s ease;
}


</style>

<div class="carousel">
    <div class="img load">
        <img src="https://d2v9y0dukr6mq2.cloudfront.net/video/thumbnail/rZJIMvhmliwmde8a6/top-view-of-ribeye-steak-wooden-board-with-food-rotating-have-a-lunch-in-restaurant_sirwntvoe_thumbnail-full01.png">
    </div>
    <div class="img load">
        <img src="https://i1.wp.com/welovebudapest.com/en/wp-content/uploads/sites/2/2015/12/d14be81afb4c1e7f85db30c173d2ff3a.jpg?resize=1920%2C1080&ssl=1">
    </div>
    <div class="img load">
        <img src="https://d2v9y0dukr6mq2.cloudfront.net/video/thumbnail/rZJIMvhmliwmde8a6/videoblocks-eggs-benedict-with-vegetables-restaurant-lunch-top-view_rrgl4eoghg_thumbnail-full01.png">
    </div>
    <div class="img load">
        <img src="https://d2v9y0dukr6mq2.cloudfront.net/video/thumbnail/rZJIMvhmliwmde8a6/videoblocks-ribeye-steak-top-view-dish-with-madagascar-pepper-sauce_haq101_zsm_thumbnail-full01.png">
    </div>
    <div class="img load">
        <img src="https://i1.wp.com/welovebudapest.com/en/wp-content/uploads/sites/2/2015/12/d14be81afb4c1e7f85db30c173d2ff3a.jpg?resize=1920%2C1080&ssl=1">
    </div>
    <div class="img load">
        <img src="https://d2v9y0dukr6mq2.cloudfront.net/video/thumbnail/rZJIMvhmliwmde8a6/videoblocks-eggs-benedict-with-vegetables-restaurant-lunch-top-view_rrgl4eoghg_thumbnail-full01.png">
    </div>
    <div class="img load clear">
        <div class="clear">
    </div>
</div>