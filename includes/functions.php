<?php

require_once 'db.php';

class User // Класс User
{
    protected $db;
    public function __construct() // Функция конструктор
    {
        $this->db = new DB_connect();
        $this->db = $this->db->ret_obj();
    }

    public function registrationUser($username, $email, $password) // Функция регистрации пользователя
    {
        $password = md5($password);

        // Проверка доступности имени пользователя и электронной почты в БД

        $query = "SELECT * FROM users WHERE uname='$username' OR uemail='$email'";

        $result = $this->db->query($query) or die($this->db->error);
        $count_row = $result->num_rows;

        if ($count_row == 0) { // Если пользователя с таким именем и E-mail не существует, то регистрируем пользователя

            $query = "INSERT INTO users SET uname='$username', uemail='$email', upass='$password'";
            $result = $this->db->query($query) or die($this->db->error);
            $_SESSION['name'] = $username;

            if ($result) { // Выполняем поиск uid пользователя чтобы добавить его в сессию
                $query = "SELECT uid FROM users WHERE uname='$username' AND upass='$password'";
                $result = $this->db->query($query) or die($this->db->error);
                $user_data = $result->fetch_array(MYSQLI_ASSOC);
                $count_row = $result->num_rows;
                $_SESSION['uid'] = $user_data['uid'];
                return true;
                if ($count_row == 1) {
                    $_SESSION['uid'] = $user_data['uid'];
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function check_login($name, $password) // Функция авторизации пользователя
    {

        $password = md5($password);

        $query = "SELECT uid FROM users WHERE uname='$name' AND upass='$password'";
        $result = $this->db->query($query) or die($this->db->error);
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        $count_row = $result->num_rows;

        if ($count_row == 1) { // Если пользователь найден то выполняем следующие действия
            $uid = $user_data['uid'];
            $query = "SELECT uname FROM users WHERE uid = '$uid'";
            $result = $this->db->query($query) or die($this->error);
            $user_data = $result->fetch_array(MYSQLI_ASSOC);
            $_SESSION['name'] = $user_data['uname'];
            $_SESSION['uid'] = $uid;
            return true;
        } else {
            return false;
        }
    }

    public function get_fullname($uid) // Функция проверки существования пользователя
    {
        $query = "SELECT uname FROM users WHERE uid = '$uid'";
        $result = $this->db->query($query) or die($this->error);
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        echo $user_data['uname'];
    }

    public function user_logout() // Выход пользователя из сессии
    {
        $_SESSION['login'] = false;
        unset($_SESSION);
        session_destroy();
        header("Location: ../index.php");
    }

    public function books() // Функция вывода книг каталога(по умолчанию)
    {
        $limit = 9;
        echo '<div class="books__list" id="books__list">';
        $query = "SELECT * FROM `books` LIMIT $limit";
        $result = $this->db->query($query) or die($this->db->error);
        $book_id = '';
        while ($read_books = $result->fetch_array(MYSQLI_ASSOC)) {
            $book_id = $read_books['id'];
            $img = $read_books['img'];
            $title = $read_books['title'];
            $author = $read_books['author'];
            echo '<div class="books__item">
        <div class="item-books__img">
            <img src="../img/' . $img . '" alt="' . $title . '">
        </div>';
            echo '<h2 class="item-books__title">' . $title . '</h2>
        <span class="item-books__author">' . $author . '</span>';
            if (isset($_SESSION['name'])) {
                echo "<a href=\"includes/book_reading_page.php?id=$book_id\" class='item-books__button'>Читать</a>"; ?>
                <button class="item-books__will_read will_read-<?= $book_id ?>" onClick="AjaxWillRead('<?= $book_id ?>,<?= $title ?>,<?= $author ?>')">Читать позже</button>
<?php }
            echo '</div>';
        }
        echo '</div>
<div id="remove_row">';
        echo '<button class="button__read_more form-control" type="button" name="btn_more" data-vid="' . $book_id . '" id="btn_more">Ещё книги...</button>
</div>';
    }

    public function AjaxBookOutput($lastBook_id) // Функция вывода книг если была нажата кнопка "Ещё книги..." 
    {
        $output = '';
        $book_id = '';
        $query_num = "SELECT COUNT(*) as num_rows FROM books WHERE id < $lastBook_id";
        $result_query_num = $this->db->query($query_num) or die($this->error);
        $row_num = $result_query_num->fetch_array(MYSQLI_ASSOC);
        $totalRowCount = $row_num['num_rows'];
        $showLimit = 9;
        $query = "SELECT * FROM `books` WHERE id > $lastBook_id LIMIT $showLimit";
        $result = $this->db->query($query) or die($this->error);
        if ($row = $result->num_rows > 0) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $book_id = $row["id"];
                $img = $row['img'];
                $title = $row['title'];
                $author = $row['author'];
                $output .= '<div class="books__item"> 
        <div class="item-books__img">
                <img src="../img/' . $img . '" alt="' . $title . '">
            </div>
                <h2 class="item-books__title">' . $title . '</h2>
                <span class="item-books__author">' . $author . '</span>';
                if (isset($_SESSION['name'])) {
                    $output .= "<a href=\"includes/book_reading_page.php?id=$book_id\" class='item-books__button'>Читать</a>";
                    $output .= "<button class='item-books__will_read will_read-$book_id' onClick='AjaxWillRead($book_id)'>Читать позже</button>";
                }
                $output .= '</div>';
            }
            if ($totalRowCount < $showLimit) {
                $output .= '<div id="remove_row"><button type="button" name="btn_more" data-vid="' . $book_id . '" id="btn_more" class="button__read_more form-control">Ещё книги...</button></div>';
            }
            $output .= '</div>';
            echo $output;
        }
    }

    public function bookReadingPage($id) // Функция вывода книги т.е. чтобы читать книгу
    {
        $query = "SELECT * FROM `books` WHERE id='$id'";
        $result = $this->db->query($query) or die($this->db->error);
        while ($book = $result->fetch_array(MYSQLI_ASSOC)) {
            $img  = $book['img'];
            $title  = $book['title'];
            $author = $book['author'];
            $description = $book['description'];
            echo ' <h1 class="title">' . $title . '</h1>
            <h3 class="title">' . $author . '</h3>
            <div class="item-books__img margin-books__img">
            <img src="../img/' . $img . '" alt="' . $title . '">
            </div>
            <p class="book_description"><h3 class="title description__title">Описание</h3><br>' . $description . '</p>
            <p class="text_book"><h3 class="title">Книга:</h3><br></p>';
        }
    }

    public function BooksViewed() // Функция вывода просмотренных книг
    {
        $uid = $_SESSION['uid'];
        $query = "SELECT * FROM `books_viewed` WHERE user_uid='$uid'";
        $result = $this->db->query($query) or die($this->error);
        $count_result = $result->num_rows;
        if ($count_result > 0) {
            $output = '';
            while ($read_books = $result->fetch_array(MYSQLI_ASSOC)) {
                $id = $read_books['id'];
                $img = $read_books['img'];
                $title = $read_books['title'];
                $author = $read_books['author'];
                $users_id = $read_books['users_id'];
                $output .= '<div class="books__item books__item-' . $id . '"><div class="item-books__img">
                <img src="../img/' . $img . '" alt="' . $title . '">
                </div>
                <h2 class="item-books__title">' . $title . '</h2>
                <span class="item-books__author">' . $author . '</span>';
                $output .= "<a href=\"book_reading_page.php?id=$users_id\" class='item-books__button'>Читать</a>";
                $output .= "<button class='item-books__viewed books_viewed-$id' onClick='deleteBookViewed($id)'>Удалить</button>
                </div>";
            }
        } else {
            $output .= '<span>Просмотренных книг нет!</span>';
        }
        echo $output;
    }

    public function addToBooksViewed($id, $uid) // Функция добавления книги в каталог "Просмотренные книги"
    {
        $query = "SELECT * FROM `books` WHERE id='$id'";
        $result = $this->db->query($query) or die($this->error);
        $books = $result->fetch_array(MYSQLI_ASSOC);
        $id = $books['id'];
        $img = $books['img'];
        $title = $books['title'];
        $author = $books['author'];

        $query = "SELECT * FROM `books_viewed` WHERE users_id='$id' AND user_uid='$uid'";
        $result = $this->db->query($query) or die($this->db->error);
        $count_row = $result->num_rows;

        if ($count_row == 1) { // Если такая книга уже есть в каталоге "Просмотренные книги" то не добавляем
            return false;
        } else { // или добавляем книгу в каталог "Просмотренные книги"
            $query = "INSERT INTO `books_viewed` (img, title, author, users_id, user_uid) VALUES ('$img', '$title', '$author', '$id', '$uid')";
            $result = $this->db->query($query) or die($this->error);
        }
    }

    public function deleteBookViewed($id, $uid) // Функция удаления книги из каталога "Просмотренные книги"
    {
        $query = "DELETE FROM `books_viewed` WHERE id='$id' AND user_uid='$uid'";
        $result = $this->db->query($query) or die($this->error);
    }

    public function readTheBook() // Функция вывода кнги из каталога "Прочитанных книги"
    {
        $uid = $_SESSION['uid'];
        $query = "SELECT * FROM `read_the_book` WHERE user_uid='$uid'";
        $result = $this->db->query($query) or die($this->error);
        $count_result = $result->num_rows;
        if ($count_result > 0) {
            $output = '';
            while ($read_books = $result->fetch_array(MYSQLI_ASSOC)) {
                $id = $read_books['id'];
                $img = $read_books['img'];
                $title = $read_books['title'];
                $author = $read_books['author'];
                $users_id = $read_books['users_id'];
                $output .= '<div class="books__item books__item-' . $id . '"><div class="item-books__img">
                <img src="../img/' . $img . '" alt="' . $title . '">
                </div>
                <h2 class="item-books__title">' . $title . '</h2>
                <span class="item-books__author">' . $author . '</span>';
                $output .= "<a href=\"book_reading_page.php?id=$users_id\" class='item-books__button'>Читать</a>";
                $output .= "<button class='item-books__viewed books_viewed-$id' onClick='deleteReadBook($id)'>Удалить</button>
                </div>";
            }
        } else {
            $output .= '<span>Прочитанных книг нет!</span>';
        }
        echo $output;
    }

    public function addToReadList($id, $uid) // Функция добавления книги в каталог "Прочитанные книги"
    {
        $query = "SELECT * FROM `books` WHERE id='$id'";
        $result = $this->db->query($query) or die($this->error);
        $books = $result->fetch_array(MYSQLI_ASSOC);
        $id = $books['id'];
        $img = $books['img'];
        $title = $books['title'];
        $author = $books['author'];

        $query = "SELECT * FROM `read_the_book` WHERE users_id='$id' AND user_uid='$uid'";
        $result = $this->db->query($query) or die($this->db->error);
        $count_row = $result->num_rows;

        if ($count_row == 1) { // Если такая книга уже есть в списке прочитанных то не добавляем
            echo "Добавлена ранее!";
            return false;
        } else { // или добавляем книгу в каталог "Прочитанные книги"
            $query = "INSERT INTO `read_the_book` (img, title, author, users_id, user_uid) VALUES ('$img', '$title', '$author', '$id', '$uid')";
            $result = $this->db->query($query) or die($this->error);
            echo "Книга добавлена!";
        }
    }

    public function deleteReadBook($id, $uid) // Функция удаления книги из каталога "Прочитанные книги"
    {
        $query = "DELETE FROM `read_the_book` WHERE id='$id' AND user_uid='$uid'";
        $result = $this->db->query($query) or die($this->error);
    }

    public function willRead() // Функция вывода книг из каталога "Читать позже"
    {
        $uid = $_SESSION['uid'];
        $query = "SELECT * FROM `i_will_read` WHERE user_uid='$uid'";
        $result = $this->db->query($query) or die($this->error);
        $count_result = $result->num_rows;
        if ($count_result > 0) {
            $output = '';
            while ($read_books = $result->fetch_array(MYSQLI_ASSOC)) {
                $id = $read_books['id'];
                $img = $read_books['img'];
                $title = $read_books['title'];
                $author = $read_books['author'];
                $users_id = $read_books['users_id'];

                $output .= '<div class="books__item books__item-' . $id . '"><div class="item-books__img">
                <img src="../img/' . $img . '" alt="' . $title . '">
                </div>
                <h2 class="item-books__title">' . $title . '</h2>
                <span class="item-books__author">' . $author . '</span>';
                $output .= "<a href=\"book_reading_page.php?id=$users_id\" class='item-books__button'>Читать</a>";
                $output .= "<button class='item-books__will_read will_read-$id' onClick='deleteWillRead($id)'>Удалить</button>
                </div>";
            }
        } else {
            $output .= '<span>Вы ещё ничего не добавили в этот раздел!</span>';
        }
        echo $output;
    }

    public function addToWillRead($id, $uid) // Функция добавления книги в каталог "Читать позже"
    {
        $query = "SELECT * FROM `books` WHERE id='$id'";
        $result = $this->db->query($query) or die($this->error);
        $books = $result->fetch_array(MYSQLI_ASSOC);
        $id = $books['id'];
        $img = $books['img'];
        $title = $books['title'];
        $author = $books['author'];

        $query = "SELECT * FROM `i_will_read` WHERE users_id='$id' AND user_uid='$uid'";
        $result = $this->db->query($query) or die($this->db->error);
        $count_row = $result->num_rows;

        if ($count_row == 1) { // Если такая книга уже есть в каталоге то добавлять не надо
            echo "Нет";
            return false;
        } else {
            $query = "INSERT INTO `i_will_read` (img, title, author, users_id, user_uid) VALUES ('$img', '$title', '$author', '$id', '$uid')";
            $result = $this->db->query($query) or die($this->error);
            if ($result) {
                echo "Да";
            }
        }
    }

    public function deleteWillRead($id, $uid) // Функция удаления книги из каталога "Читать позже"
    {
        $query = "DELETE FROM `i_will_read` WHERE id='$id' AND user_uid='$uid'";
        $result = $this->db->query($query) or die($this->error);
    }
}

class Chat // Класс Chat
{
    protected $db;
    public function __construct() // Функция конструктор
    {
        $this->db = new DB_connect();
        $this->db = $this->db->ret_obj();
    }

    public function MessageOutput() // Функция вывода сообщений
    {
        $query = "SELECT * FROM `chat`";
        $result = $this->db->query($query) or die($this->error);

        while ($chat = $result->fetch_array(MYSQLI_ASSOC)) {
            $UserName  = $chat['UserName'];
            $date_str = new DateTime($chat["datetime"]);
            $date = $date_str->Format('d.m.Y');
            $date_year = $date_str->Format('Y');
            $date_time = $date_str->Format('H:i');
            $ndate_exp = explode('.', $date);
            $nmonth = array(
                1 => 'янв',
                2 => 'фев',
                3 => 'мар',
                4 => 'апр',
                5 => 'мая',
                6 => 'июн',
                7 => 'июл',
                8 => 'авг',
                9 => 'сен',
                10 => 'окт',
                11 => 'ноя',
                12 => 'дек'
            );
            foreach ($nmonth as $key => $value) {
                if($key == intval($ndate_exp[1])) $nmonth_name = $value; }
                  if ($date == date('d.m.Y')){ $datetime = 'Cегодня в ' .$date_time;
                } else if ($date == date('d.m.Y', strtotime('-1 day'))){
                    $datetime = 'Вчера в ' .$date_time;
                } else if ($date != date('d.m.Y') && $date_year != date('Y')){
                    $datetime = $ndate_exp[0].' '.$nmonth_name.' '.$ndate_exp[2]. ' в '.$date_time;
                } else {
                    $datetime = $ndate_exp[0].' '.$nmonth_name.' в '.$date_time;
                }
            $Message  = $chat['Message'];
            $SessionName = $_SESSION['name'];
            if ($UserName == $SessionName) {
                echo '<div class="OneUser">
                <div class="OneUser__margin-message">
                <h3 class="one-user">' . $UserName . '</h3>
                <p class="MessageWidth_OneUser">' . $Message . '</p>
                <span class="Chat__datatime--OneUser">' . $datetime . '</span>
            </div></div>';
            } else {
                echo '<div class="TwoUser">
                <div class="TwoUser__margin-message">
                <h3 class="two-user">' . $UserName . '</h3>
                <p class="MessageWidth_TwoUser">' . $Message . '</p>
                <span class="Chat__datatime--TwoUser">' . $datetime . '</span>
            </div></div>';
            }
        }
    }

    public function AddMessageChat($name, $message) // Функция отправки сообщения
    {
        $uid = $_SESSION['uid'];
        $date = date('Y-m-d H:i');
        $query = "INSERT INTO `chat` (`IdUser`, `UserName`, `Message`, `datetime`) VALUES ('$uid', '$name', '$message', '$date')";
        $result = $this->db->query($query) or die($this->error);
    }
}
