<?php
session_start();

if (isset($_SESSION['name'])) {

    include_once 'functions.php';
    include_once 'header.php';
    $user = new User;

    if (isset($_GET['id']) || isset($_GET['users_id'])) {  // проверка отправки id книги и id сессии пользователя 
        ?>
        <div class="wrapper">
            <section class="books">
                <?php
                        $id = $_GET['id'];
                        $users_id = $_GET['users_id'];
                        $uid = $_SESSION['uid'];
                        $user->bookReadingPage($id, $users_id); // Вызов функции вывода книги 
                        $user->addToReadList($id, $uid); // Добавление функции в список прочитанных
                        ?>
            </section>
        </div>

<?php
    }
} else {
    header("Location: ../index.php");
}
