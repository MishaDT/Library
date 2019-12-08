$(document).ready(function () {
    $(document).on('click', '#btn_more', function () {
        var last_video_id = $(this).data("vid");
        $('#btn_more').html("Ещё книги...");
        $.ajax({
            url: "../includes/AjaxBookOutput.php",
            method: "POST",
            data: {
                last_video_id: last_video_id
            },
            dataType: "text",
            success: function (data) {
                if (data != '') {
                    $('#remove_row').remove();
                    $('#books__list').append(data);
                } else {
                    $('#btn_more').remove();
                }
            }
        });
    });
});