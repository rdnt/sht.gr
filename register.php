<?php include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/head.php"; ?>
<title><?=$sht->page_title("Register")?></title>
</head>
<body>
<main>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/pages/register.php"; ?>
</main>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/scripts.php"; ?>
<script>
function shake(div) {
    var interval = 100;
    var distance = 4;
    var times = 2;

    $(div).css('position', 'relative');

    for (var iter = 0; iter < (times + 1); iter++) {
        $(div).animate({
            left: ((iter % 2 == 0 ? distance : distance * -1))
        }, interval);
    }

    $(div).animate({
        left: 0
    }, interval);

}
function invalid_field(id, color) {
    $(id).addClass("login-fail-" + color);
    setTimeout(function(){$(id).removeClass("login-fail-" + color)}, 250);
    setTimeout(function(){$(id).addClass("login-fail-" + color)}, 500);
    setTimeout(function(){$(id).removeClass("login-fail-" + color)}, 750);
    console.log("NOW");
    shake(id + "-container");
}
$("#register_form").submit(function(e) {
    $.ajax({
        method: "POST",
        url: "/backend/register",
        data: $("#register_form").serialize(),
        success: function(data) {
            console.log(data);
            if ($.trim(data) === "SUCCESS") {
                // One factor authentication successful
                window.location.replace("/");
            }
            else if ($.trim(data) === "EMPTY_USERNAME") {
                // Error
                invalid_field("#username", "grey");
            }
            else if ($.trim(data) === "EMPTY_EMAIL") {
                // Error
                invalid_field("#email", "grey");
            }
            else if ($.trim(data) === "EMPTY_PASSWORD") {
                // Error
                invalid_field("#password", "grey");
            }
            else if ($.trim(data) === "EMPTY_REPEAT_PASSWORD") {
                // Error
                invalid_field("#repeat-password", "grey");
            }
            else if ($.trim(data) === "INVALID_USERNAME") {
                // Error
                invalid_field("#username", "red");
            }
            else if ($.trim(data) === "INVALID_EMAIL") {
                // Error
                invalid_field("#email", "red");
            }
            else if ($.trim(data) === "INVALID_PASSWORD") {
                // Error
                invalid_field("#password", "red");
            }
            else if ($.trim(data) === "PASSWORDS_DONT_MATCH") {
                // Error
                invalid_field("#password", "red");
                invalid_field("#repeat-password", "red");
            }
            else if ($.trim(data) === "ACCOUNT_ALREADY_EXISTS") {
                // Error
                invalid_field("#username", "red");
            }
            else {
                invalid_field("#username", "red");
                invalid_field("#email", "red");
                invalid_field("#password", "red");
                invalid_field("#repeat-password", "red");
            }
        }
    });
    e.preventDefault();
});
</script>
</body>
</html>
