function callback(data) {
    Console.log(data);
}
$(window).on("load", function() {
    if (asyncRequest instanceof Function) {
        asyncRequest("#form", "/api/endpoint", null, callback);
    }
    else {
        Console.log("Function asyncRequest() not loaded.");
    }
});
