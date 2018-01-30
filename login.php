<?php include_once $_SERVER['DOCUMENT_ROOT']."/backend/core/sht-cms.php"; ?>
<?php
if (isset($_SESSION['login'])) {
    // Send the user to the homepage
    header("Location: /");
    // Do not execute any other code
    die();
}
?>
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
    shake(id + "-container");
}
$("#code_form").submit(function(e) {
    $.ajax({
        method: "POST",
        url: "/backend/code-auth",
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
                M.toast({html: "An unknown error has occured."});
            }
        }
    });
    e.preventDefault();
});
var fingerprint_signal = 0;
var fingerprint_flag = 0;
var failed = 0;
function do_fingerprint_auth() {
    var token = Math.random().toString(36).substr(2, 10);
    document.getElementById("token").value = token;
    (function check_fingerprint (i) {
        setTimeout(function () {
            if (fingerprint_signal == 0 && fingerprint_flag != -1) {
                document.getElementById("fingerprint_auth_btn").click();
            }
            if (--i && fingerprint_flag != -1) {
                check_fingerprint(i);
            }
            else {
                $("#fingerprint_form i").removeClass("blue-grey-text");
                $("#fingerprint_form i").removeClass("grey-text");
                $("#fingerprint_form i").addClass("red-text");
                $(".animated-fingerprint").one('animationiteration webkitAnimationIteration', function() {
                    $(this).removeClass("animated-fingerprint");
                });
                failed = 1;
            }
        }, 1000);
    })(30);
}
$("#fingerprint_form").submit(function(e) {
    $.ajax({
        method: "POST",
        url: "/backend/fingerprint-auth",
        data: $("#fingerprint_form").serialize(),
        success: function(data) {
            if ($.trim(data) === "SUCCESS") {
                // Two factor authentication successful
                fingerprint_signal = 1;

                $("#fingerprint_form i").removeClass("blue-grey-text");
                $("#fingerprint_form i").removeClass("grey-text");

                $("#fingerprint_form i").addClass("blue-text");
                $(".animated-fingerprint").one('animationiteration webkitAnimationIteration', function() {
                    $(this).removeClass("animated-fingerprint");
                    setTimeout(function () {
                        window.location.replace("/");
                    }, 1000);
                });
            }
            else if ($.trim(data) === "AWAITING_FINGERPRINT") {
                // Waiting for fingerprint
                $("#fingerprint_form i").removeClass("text-darken-1");
                if (failed == 0) {
                    $("#fingerprint_form i").addClass("grey-text");
                }

            }
            else if ($.trim(data) === "FINGERPRINT_AUTH_TIMEOUT") {
                // Fingerprint request has timed out
                fingerprint_flag = -1;
                $("#fingerprint_form i").addClass("red-text");
                $(".animated-fingerprint").one('animationiteration webkitAnimationIteration', function() {
                    $(this).removeClass("animated-fingerprint");
                });
            }
            else if ($.trim(data) === "FINGERPRINT_AUTH_RESET") {
                // Fingerprint request initiated
                $("#fingerprint_form i").addClass("blue-grey-text text-darken-1");
            }
            else if ($.trim(data) === "FINGERPRINT_AUTH_DUPLICATE") {
                // Fingerprint request initiated
                fingerprint_flag = -1;
                $("#fingerprint_form i").addClass("red-text");
                $(".animated-fingerprint").one('animationiteration webkitAnimationIteration', function() {
                    $(this).removeClass("animated-fingerprint");
                });
            }

            else {
                // Error
                fingerprint_flag = -1;
                $("#fingerprint_form i").addClass("red-text");
                $(".animated-fingerprint").one('animationiteration webkitAnimationIteration', function() {
                    $(this).removeClass("animated-fingerprint");
                });
                M.toast({html: "An unknown error has occured."});
            }
        }
    });
    e.preventDefault();
});
</script>
</body>
</html>
