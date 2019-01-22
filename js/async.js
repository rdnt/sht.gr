var pending = 0;
function asyncRequest(formID, targetURL, init, callback, successDelay, errorDelay) {
    $(formID).submit(function(e) {
        e.preventDefault();
        if (!pending) {
            if (targetURL instanceof Function) {
                targetURL = targetURL();
            }
            else {
                targetURL = targetURL;
            }
            if (init instanceof Function) {
                init();
            }
            pending = 1;
            var start = new Date();
            $.ajax({
                method: "POST",
                url: targetURL,
                data: $(this).serialize(),
                success: function(data) {
                    data = $.trim(data);
                    var duration = new Date() - start;
                    try {
                        data = JSON.parse(data);
                    }
                    catch (e) {
                        data = { response: "JSON_PARSE_FAILED", data: data };
                    }
                    if (data["response"] === "SUCCESS") {
                        setTimeout(function() {
                            callback(data);
                            pending = 0;
                        }, successDelay - duration);
                    }
                    else {
                        setTimeout(function() {
                            callback(data);
                            pending = 0;
                        }, errorDelay - duration);
                    }
                },
                error(request) {
                    var data = { "response": "REQUEST_FAILED", "data": request.status + " " + request.statusText.toUpperCase() };
                    callback(data);
                }
            });
        }
    });
}
