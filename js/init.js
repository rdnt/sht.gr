function callback(data) {
    console.log(data);
}
$(window).on("load", function() {
    asyncRequest("#login", "/api/endpoint", null, callback);
});
