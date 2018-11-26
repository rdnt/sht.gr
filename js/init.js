function callback(data) {
    console.log(data);
}
$(window).on("load", function() {
    if (asyncRequest instanceof Function) {
        asyncRequest("#form", "/api/endpoint", null, callback);
    }
    else {
        console.log("Function asyncRequest() not loaded.")
    }
});
