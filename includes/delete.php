<?php
session_start();
include_once 'functions.php';
$user = new User;

if (isset($_SESSION['name'])) {
    $id = $_GET['id'];
    $uid = $_SESSION['uid'];
    $read = $user->deleteWillRead($id, $uid); // Вызов функции удаления книги из списка "буду читать"
} else {
    return false;
    header("Location: list_will_read.php");
}
