$(document).ready(function () {

    $(window).scroll(function () {
        if ($(this).scrollTop() > 600) {
            $('.two_margin').fadeIn();
        } else {
            $('.two_margin').fadeOut();
        }
    });

    $('.two_margin').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

});

$(document).ready(function () {
    $("#InputMessage").keyup(function (e) {
        var InputMessage = $("#InputMessage").val();
        var sub = document.getElementById("FormSub");
        if (e.keyCode == 13 && InputMessage[0] != "\n") {
            $.ajax({
                type: 'POST',
                url: "AddMessageChat.php",
                data: {
                    InputMessage: InputMessage
                },
                success: function () {
                    $("#BlockMessage").load("DisplayMessagesOnce.php");
                    $("#InputMessage").val("");
                }
            });
        }

    });

    $("input[type=submit]").on("click", function (e) {
        var InputMessage = $("#InputMessage").val();
        $.ajax({
            type: 'POST',
            url: "AddMessageChat.php",
            data: {
                InputMessage: InputMessage
            },
            success: function () {
                $("#BlockMessage").load("DisplayMessagesOnce.php");
                $("#InputMessage").val("");
            }
        });
    });

    setInterval(function () {
        $("#BlockMessage").load("DisplayMessages.php");
    }, 1500);

    $("#BlockMessage").load("DisplayMessagesOnce.php");
});