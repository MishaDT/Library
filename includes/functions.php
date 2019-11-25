<?php

include_once 'db.php';

class User // Класс с полным набором функций
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

    public function readTheBook() // Функция вывода прочитанных книг
    {
        $uid = $_SESSION['uid'];
        $query = "SELECT * FROM `read_the_book` WHERE user_uid='$uid'";
        $result = $this->db->query($query) or die($this->error);
        $count_result = $result->num_rows;
        if ($count_result >= 1) {
            while ($read_books = $result->fetch_array(MYSQLI_ASSOC)) {
                echo '<div class="books__item">
                <div class="item-books__img">
                    <img src="../img/' . $read_books['img'] . '" alt="' . $read_books['tite'] . '">
                </div>
                    <h2 class="item-books__title">' . $read_books['title'] . '</h2>
                    <span class="item-books__author">' . $read_books['author'] . '</span>
                </div>';
            }
        } else if ($count_result == 0) { // Если в списке прочитанных книг пусто (0) 
            echo '<span>Вы ещё ничего не читали!</span>';
        }
    }

    public function deleteWillRead($id, $uid) // Функция удаления книги из списка "буду читать"
    {
        $query = "DELETE FROM `i_will_read` WHERE id='$id' AND user_uid='$uid'";
        $result = $this->db->query($query) or die($this->error);
        if ($result) {
            header('Location: list_will_read.php');
        } else {
            header('Location: list_will_read.php');
        }
    }

    public function books() // Функция вывода каталога всех книг
    {
        $query = "SELECT * FROM `books`";
        $result = $this->db->query($query) or die($this->error);
        while ($read_books = $result->fetch_array(MYSQLI_ASSOC)) {
            $id = $read_books['id'];
            $img = $read_books['img'];
            $title = $read_books['title'];
            $author = $read_books['author'];
            echo '<div class="books__item">
                <div class="item-books__img">
                    <img src="../img/' . $img . '" alt="' . $title . '">
                </div>
                    <h2 class="item-books__title">' . $title . '</h2>
                    <span class="item-books__author">' . $author . '</span>';
            if (isset($_SESSION['name'])) {
                echo "<a href=\"includes/book_reading_page.php?id=$id\" class='item-books__button'>Читать</a>";
                echo "<a href=\"includes/i_will_read.php?id=$id?title=$title?author=$author\" style='text-decoration: underline; color: #000;' class='item-books__will_read'>Читать позже</a>";
            }
            echo '</div>';
        }
    }

    public function addToReadList($id, $uid) // Функция добавления книги в список прочитанных
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

        if ($count_row == 1) { // Есди такая книга уже есть в списке прочитанных то не добавляем
            return false;
        } else { // или добавляем в список прочитанных
            $query = "INSERT INTO `read_the_book` (img, title, author, users_id, user_uid) VALUES ('$img', '$title', '$author', '$id', '$uid')";
            $result = $this->db->query($query) or die($this->error);
        }
    }

    public function willRead() // Функция вывода книг из списка "прочитать позже"
    {
        $uid = $_SESSION['uid'];
        $query = "SELECT * FROM `i_will_read` WHERE user_uid='$uid'";
        $result = $this->db->query($query) or die($this->error);
        $count_result = $result->num_rows;
        if ($count_result >= 1) {
            while ($read_books = $result->fetch_array(MYSQLI_ASSOC)) {
                echo '<div class="books__item"><div class="item-books__img">';
                echo '<img src="../img/' . $read_books['img'] . '" alt="' . $read_books['tite'] . '">
                </div>
                <h2 class="item-books__title">' . $read_books['title'] . '</h2>
                <span class="item-books__author">' . $read_books['author'] . '</span>';
                $id = $read_books['id'];
                $users_id = $read_books['users_id'];
                $title = $read_books['title'];
                $author = $read_books['author'];
                echo "<a href=\"book_reading_page.php?id=$users_id\" class='item-books__button'>Читать</a>
                    <a href=\"delete.php?id=$id\" style='text-decoration: underline; color: #000;'>Удалить</a>";
                echo "</div>";
            }
        } else if ($count_result == 0) {
            echo '<span>Вы ещё ничего не добавили в этот раздел!</span>';
        }
    }

    public function addToWillRead($id, $uid, $title, $author) // Функция добавления книги в список "читать позже"
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

        if ($count_row == 1) { // Если такая книга уже есть в списке то добавлять не надо
            return false;
        } else {
            $query = "INSERT INTO `i_will_read` (img, title, author, users_id, user_uid) VALUES ('$img', '$title', '$author', '$id', '$uid')";
            $result = $this->db->query($query) or die($this->error);
        }
    }

    public function bookReadingPage($id, $users_id) // Функция вывода книги
    {
        $query = "SELECT * FROM `books` WHERE id='$id' OR id='$users_id'";
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
}

class Chat
{
    protected $db;
    public function __construct() // Функция конструктор
    {
        $this->db = new DB_connect();
        $this->db = $this->db->ret_obj();
    }

    public function MessageOutput()
    {
        $query = "SELECT * FROM `chat`";
        $result = $this->db->query($query) or die($this->error);
        while ($chat = $result->fetch_array(MYSQLI_ASSOC)) {
            $UserName  = $chat['UserName'];
            $Message  = $chat['Message'];
            $SessionName = $_SESSION['name'];
            if ($UserName == $SessionName) {
                echo '<div class="margin-message">
                <h3 class="one-user">' . $UserName . '</h3>
                <p class="MessageWidth">' . $Message . '</p>
            </div>';
            } else {
                echo '<div class="margin-message">
                <h3 class="two-user">' . $UserName . '</h3>
                <p class="MessageWidth">' . $Message . '</p>
            </div>';
            }
        }
    }

    public function AddMessageChat($name, $message)
    {
        $uid = $_SESSION['uid'];
        $query = "INSERT INTO `chat` (`IdUser`, `UserName`, `Message`) VALUES ('$uid', '$name', '$message')";
        $result = $this->db->query($query) or die($this->error);
    }
}
