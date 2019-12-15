<?php
session_start();
require_once 'functions.php';
$user = new User();

if (isset($_SESSION['name'])) { // Если пользователь авторизован
    $id = $_GET['id'];
    $uid = $_SESSION['uid'];
    $title = $_GET['title'];
    $author = $_GET['author'];
    $read = $user->addToWillRead($id, $uid, $title, $author); // Вызов функции добавления книги в каталог "Читать позже"
    if (!$read) {
        header("Location: ../index.php");
    } else {
        header("Location: ../index.php");
    }
} else {
    return false;
    header("Location: ../index.php");
}
