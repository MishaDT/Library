<?php
session_start();
require_once 'functions.php';
$user = new User();

if (isset($_SESSION['name'])) {
    $id = $_POST['id'];
    $uid = $_SESSION['uid'];
    $user->addToReadList($id, $uid); // Вызов функции добавления книги в каталог "Прочитанные книги"
} else {
    return false;
    header("Location: ../index.php");
}
