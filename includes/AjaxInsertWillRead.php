<?php
session_start();
include_once 'functions.php';
$user = new User();
$video_id = $_POST['video_id'];
$uid = $_SESSION['uid'];
$read = $user->addToWillRead($video_id, $uid); // Вызов функции для добавления книги в список "читать позже"
