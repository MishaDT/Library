function AjaxWillRead(video_id) {
    $.ajax({
        type: "POST",
        url: "../includes/AjaxInsertWillRead.php",
        data: {
            video_id: video_id
        },
        success: function(data){
            if(data == "Нет") {
                $('.will_read-'+video_id+'').html('Добавлена ранее');
                $('.will_read-'+video_id+'').css('color','#fb9292');
            }
            if(data == "Да") {
                $('.will_read-'+video_id+'').html('Успешно добавлена');
                $('.will_read-'+video_id+'').css('color','#009688');
            }
        }
    });
}

function up() {
    var top = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
    if (top > 0) {
        window.scrollBy(0, ((top + 100) / -10));
        t = setTimeout('up()', 20);
    } else clearTimeout(t);
    return false;
}
jQuery(function (f) {
    var element = f('#button_top');
    f(window).scroll(function () {
        element['fade' + (f(this).scrollTop() > 200 ? 'In' : 'Out')](250);
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