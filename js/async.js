var ajaxRequestPending = 0;
function asyncFormSubmission(form_id, target_url, init, callback, min_delay, error_delay, rapid_error) {
    $(form_id).submit(function(e) {
        e.preventDefault();
        if (!ajaxRequestPending) {
            var url = "";
            if (target_url instanceof Function) {
                url = target_url();
            }
            else {
                url = target_url;
            }
            init();
            ajaxRequestPending = 1;
            var start = new Date();
            $.ajax({
                method: "POST",
                url: url,
                data: $(this).serialize(),
                success: function(data) {
                    data = $.trim(data);
                    var duration = new Date() - start;
                    try {
                        data = JSON.parse(data);
                    }
                    catch(e) {
                        data = {"response": "JSON_PARSE_FAILED"};
                    }
                    if (data['response'] === "SUCCESS" || rapid_error === false) {
                        setTimeout(function(){
                            ajaxRequestPending = 0;
                            callback(data);
                        }, min_delay - duration);
                    }
                    else if (rapid_error === true) {
                        callback(data);
                        setTimeout(function(){
                            ajaxRequestPending = 0;
                        }, error_delay);
                    }
                    else {
                        setTimeout(function(){
                            callback(data);
                            ajaxRequestPending = 0;
                        }, error_delay);
                    }
                }
            });
        }
    });
}
