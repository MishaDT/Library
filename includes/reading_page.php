<?php
session_start();
include_once 'functions.php';
$user = new User;

if (isset($_SESSION['name'])) {
    $id = $_GET['id'];
    $uid = $_SESSION['uid'];
    $read = $user->addToReadList($id, $uid); // Вызов функции для добавления книги в список прочитанных
    if (!$read) {
        header("Location: ../index.php");
    } else {
        header("Location: ../index.php");
    }
} else {
    return false;
    header("Location: ../index.php");
}
