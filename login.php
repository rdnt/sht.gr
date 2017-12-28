<?php include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/components/head.php"; ?>
<title><?=$sht->page_title("Login")?></title>
</head>
<body>
<main>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/includes/pages/login.php"; ?>
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
$("#login_form").submit(function(e) {
    $.ajax({
        method: "POST",
        url: "/backend/login",
        data: $("#login_form").serialize(),
        success: function(data) {
            if ($.trim(data) === "SUCCESS") {
                // One factor authentication successful
                window.location.replace("/");
            }
            else if ($.trim(data) === "REQUIRE_CODE_AUTH") {
                // Move to code authentication
                $(".login-wrapper #containers").addClass("login-two-step");
                $("#step").fadeOut(100);
                $("#description").fadeOut(100);
                setTimeout(function () {
                    document.getElementById("step").innerHTML = "Two Factor Authentication";
                    document.getElementById("description").innerHTML = "Insert the 6-digit code from your authenticator.";
                        $("#step").fadeIn(100);
                        $("#description").fadeIn(100);
                }, 100);
                setTimeout(function(){
                    document.getElementById("code").focus();
                }, 500);
            }
            else if ($.trim(data) === "REQUIRE_FINGERPRINT_AUTH") {
                // Move to fingerprint authentication
                $(".login-wrapper #containers .code-content").addClass("hidden");
                $(".login-wrapper #containers").addClass("login-two-step");
                $("#step").fadeOut(100);
                $("#description").fadeOut(100);
                setTimeout(function () {
                    document.getElementById("step").innerHTML = "Two Factor Authentication";
                    document.getElementById("description").innerHTML = "Open the SHT CMS app on your phone and authenticate using your fingerprint.";
                        $("#step").fadeIn(100);
                        $("#description").fadeIn(100);
                }, 100);
                do_fingerprint_auth();
            }
            else if ($.trim(data) === "EMPTY_USERNAME_PASSWORD") {
                // Error
                invalid_field("#username", "grey");
                invalid_field("#password", "grey");
            }
            else if ($.trim(data) === "EMPTY_USERNAME") {
                // Error
                invalid_field("#username", "grey");
            }
            else if ($.trim(data) === "EMPTY_PASSWORD") {
                // Error
                invalid_field("#password", "grey");
            }
            else if ($.trim(data) === "INVALID_USERNAME" || $.trim(data) === "ACCOUNT_DOES_NOT_EXIST") {
                // Error
                invalid_field("#username", "red");
            }
            else if ($.trim(data) === "INVALID_PASSWORD") {
                // Error
                invalid_field("#password", "red");
            }
            else {
                invalid_field("#username", "red");
                invalid_field("#password", "red");
            }
        }
    });
    e.preventDefault();
});
$('#code').bind('input propertychange', function() {
    if ($(this).val().length == 6) {
        document.getElementById("code_auth_btn").click();
    }
});
function invalid_field(id, color) {
    $(id).addClass("login-fail-" + color);
    setTimeout(function(){$(id).removeClass("login-fail-" + color)}, 250);
    setTimeout(function(){$(id).addClass("login-fail-" + color)}, 500);
    setTimeout(function(){$(id).removeClass("login-fail-" + color)}, 750);
    console.log("NOW");
    shake(id + "-container");
};
$("#code_form").submit(function(e) {
    $.ajax({
        method: "POST",
        url: "/backend/code-authentication",
        data: $("#code_form").serialize(),
        success: function(data) {
            if ($.trim(data) === "SUCCESS") {
                // Two factor authentication successful
                window.location.replace("/");
            }
            else if ($.trim(data) === "REQUIRE_FINGERPRINT_AUTH") {
                // Move to 3fa
                $(".login-wrapper #containers").addClass("login-three-step");
                $("#step").fadeOut(100);
                $("#description").fadeOut(100);
                setTimeout(function () {
                    document.getElementById("step").innerHTML = "Three Factor Authentication";
                    document.getElementById("description").innerHTML = "Open the SHT CMS app on your phone and authenticate using your fingerprint.";
                    $("#step").fadeIn(100);
                    $("#description").fadeIn(100);
                }, 100);
                do_fingerprint_auth();
            }
            else if ($.trim(data) === "EMPTY_CODE") {
                // Error
                invalid_field("#code", "grey");
            }
            else if ($.trim(data) === "INCORRECT_CODE") {
                // Error
                invalid_field("#code", "red");
            }
            else {
                // Error
                console.log($.trim(data));
            }
        }
    });
    e.preventDefault();
});
var fingerprint_signal = 0;
var fingerprint_flag = 0;
function do_fingerprint_auth() {
    var token = Math.random().toString(36).substr(2, 10);
    document.getElementById("token").value = token;
    (function theLoop (i) {
        setTimeout(function () {
            if (fingerprint_signal == 0) {
                document.getElementById("fingerprint_auth_btn").click();
            }
            if (--i && fingerprint_flag != -1) {
                theLoop(i);
            }
            else {
                $("#fingerprint_form i").addClass("red-text");
                $(".animated-fingerprint").one('animationiteration webkitAnimationIteration', function() {
                    $(this).removeClass("animated-fingerprint");
                });
            }
        }, 1000);
    })(30);
};
$("#fingerprint_form").submit(function(e) {
    $.ajax({
        method: "POST",
        url: "/backend/fingerprint-authentication",
        data: $("#fingerprint_form").serialize(),
        success: function(data) {
            if ($.trim(data) === "SUCCESS") {
                // Two factor authentication successful
                fingerprint_signal = 1;
                $("#fingerprint_form i").addClass("blue-text");
                $(".animated-fingerprint").one('animationiteration webkitAnimationIteration', function() {
                    $(this).removeClass("animated-fingerprint");
                    setTimeout(function () {
                        window.location.replace("/");
                    }, 500);
                });
            }
            else if ($.trim(data) === "AWAITING_FINGERPRINT") {
                // Waiting for fingerprint
            }
            else if ($.trim(data) === "FINGERPRINT_AUTH_TIMEOUT") {
                // Fingerprint request has timed out
                fingerprint_flag = -1;
                $("#fingerprint_form i").addClass("red-text");
                $(".animated-fingerprint").one('animationiteration webkitAnimationIteration', function() {
                    $(this).removeClass("animated-fingerprint");
                });
            }
            else {
                // Error
                console.log($.trim(data));
            }
        }
    });
    e.preventDefault();
});
</script>
</body>
</html>
