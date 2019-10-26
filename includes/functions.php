<?php

include_once 'db.php';

class User
{
    protected $db;
    public function __construct()
    {
        $this->db = new DB_connect();
        $this->db = $this->db->ret_obj();
    }

    /*** для процесса регистрации ***/

    public function registrationUser($username, $email, $password)
    {
        $password = md5($password);

        // проверка доступности имени пользователя или электронной почты в БД

        $query = "SELECT * FROM users WHERE uname='$username' OR uemail='$email'";

        $result = $this->db->query($query) or die($this->db->error);
        $count_row = $result->num_rows;

        if ($count_row == 0) {

            $query = "INSERT INTO users SET uname='$username', uemail='$email', upass='$password'";
            $result = $this->db->query($query) or die($this->db->error);
            $_SESSION['name'] = $username;

            if ($result) {
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

    /*** для процесса входа ***/

    public function check_login($name, $password)
    {

        $password = md5($password);

        $query = "SELECT uid FROM users WHERE uname='$name' AND upass='$password'";

        $result = $this->db->query($query) or die($this->db->error);

        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        $count_row = $result->num_rows;

        if ($count_row == 1) {
            $_SESSION['login'] = true; // это логин будет использоваться для сессии
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

    public function get_fullname($uid)
    {
        $query = "SELECT uname FROM users WHERE uid = '$uid'";
        $result = $this->db->query($query) or die($this->error);
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        echo $user_data['uname'];
    }

    public function user_logout()
    {
        $_SESSION['login'] = false;
        unset($_SESSION);
        session_destroy();
    }

    public function readTheBook()
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
        } else if ($count_result == 0) {
            echo '<span>Вы ещё ничего не читали!</span>';
        }
    }

    public function deleteWillRead($id, $uid)
    {
        $query = "DELETE FROM `i_will_read` WHERE id='$id' AND user_uid='$uid'";
        $result = $this->db->query($query) or die ($this->error);
        if($result){
            header('Location: list_will_read.php');
        } else {
            header('Location: list_will_read.php');
        }
    }

    public function books()
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

    public function addToReadList($id, $uid)
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

        if ($count_row == 1) {
            return false;
        } else {
            $query = "INSERT INTO `read_the_book` (img, title, author, users_id, user_uid) VALUES ('$img', '$title', '$author', '$id', '$uid')";
            $result = $this->db->query($query) or die($this->error);
        }
    }

    public function willRead()
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

    public function addToWillRead($id, $uid, $title, $author)
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

        if ($count_row == 1) {
            return false;
        } else {
            $query = "INSERT INTO `i_will_read` (img, title, author, users_id, user_uid) VALUES ('$img', '$title', '$author', '$id', '$uid')";
            $result = $this->db->query($query) or die($this->error);
        }
    }

    public function bookReadingPage($id, $users_id)
    {
        $query = "SELECT * FROM `books` WHERE id='$id' OR id='$users_id'";
        $result = $this->db->query($query) or die ($this->db->error);
        while($book = $result->fetch_array(MYSQLI_ASSOC)){
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
