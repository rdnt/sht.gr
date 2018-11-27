function callback(data) {
    console.log(data);
}
$(window).on("load", function() {
    asyncRequest("#form", "/api/endpoint", null, callback);
});
