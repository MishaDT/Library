<?php
session_start();
require_once 'functions.php';
$user = new User();
if (isset($_SESSION['name'])) { // Если пользователь авторизован
    $id = $_POST['id'];
    $uid = $_SESSION['uid'];
    $user->deleteWillRead($id, $uid); // Вызов функции для удаления книги из каталога "Буду читать"
} else {
    header("Location: ../index.php"); // Переадресация с страницы если пользователь не авторизован
}
