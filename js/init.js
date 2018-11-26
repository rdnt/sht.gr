function callback(data) {

}
$(window).on("load", function() {
    if (asyncRequest instanceof Function) {
        asyncRequest("#form", "/api/endpoint", null, callback);
    }
    else {
        throw new Error("Function asyncRequest() not loaded.");
    }
});
