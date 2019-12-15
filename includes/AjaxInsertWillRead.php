<?php
session_start();
require_once 'functions.php';
$user = new User();
if (isset($_SESSION['name'])) { // Если пользователь авторизован
    $video_id = $_POST['video_id'];
    $uid = $_SESSION['uid'];
    $read = $user->addToWillRead($video_id, $uid); // Вызов функции для добавления книги в список "Читать позже"
} else {
    header("Location: ../index.php"); // Переадресация на главную станицу если пользователь не авторизован
}
