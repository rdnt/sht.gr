$(window).on("load", function() {
    asyncRequest("#form", "/api/endpoint", null, callback);
});

function callback(data) {
    console.log(data);
}
