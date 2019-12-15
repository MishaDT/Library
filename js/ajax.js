function deleteBookViewed(id) { // Функция удаления книги из каталога "Просмотренные книги"
    $.ajax({
        type: "POST",
        url: "../includes/AjaxDeleteBookViewed.php",
        data: {
            id: id
        },
        success: function (data) {
            $('.books__item-' + id + '').hide(500, function load_data() {
                $.ajax({
                    url: "../includes/CallBooksViewed.php",
                    method: "POST",
                    success: function (data) {
                        $('#books__list').html(data);
                    }
                });
            });
        }
    });
}

function deleteReadBook(id) { // Функция удаления книги из каталога "Прочитанные книги"
    $.ajax({
        type: "POST",
        url: "../includes/AjaxDeleteReadBook.php",
        data: {
            id: id
        },
        success: function (data) {
            $('.books__item-' + id + '').hide(500, function load_data() {
                $.ajax({
                    url: "../includes/CallReadBooks.php",
                    method: "POST",
                    success: function (data) {
                        $('#books__list').html(data);
                    }
                });
            });
        }
    });
}

function addBookRead(id) { // Функция добавления книги в каталог "Прочитанные книги"
    $.ajax({
        type: "POST",
        url: "../includes/reading_page.php",
        data: {
            id: id
        },
        success: function (data) {
            $('.add_to_books_viewed').html(data).animate({ opacity: .5 }, 500);
        }
    });
}

function deleteWillRead(id) { // Функция удаления книги из каталога "Читать позже"
    $.ajax({
        type: "POST",
        url: "../includes/AjaxDeleteWillRead.php",
        data: {
            id: id
        },
        success: function (data) {
            $('.books__item-' + id + '').hide(500, function load_data() {
                $.ajax({
                    url: "../includes/CallWillRead.php",
                    method: "POST",
                    success: function (data) {
                        $('#books__list').html(data);
                    }
                });
            });
        }
    });
}

function AjaxWillRead(video_id) { // Функция добавления книги в каталог "Читать позже"
    $.ajax({
        type: "POST",
        url: "../includes/AjaxInsertWillRead.php",
        data: {
            video_id: video_id
        },
        success: function (data) {
            if (data == "Нет") {
                $('.will_read-' + video_id + '').html('Добавлена ранее');
                $('.will_read-' + video_id + '').css('color', '#fb9292');
            }
            if (data == "Да") {
                $('.will_read-' + video_id + '').html('Успешно добавлена');
                $('.will_read-' + video_id + '').css('color', '#009688');
            }
        }
    });
}

function up() { // Функция для работы кнопки вверх 
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