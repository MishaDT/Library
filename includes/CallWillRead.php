<?php
session_start();
require_once 'functions.php';
$user = new User();
if (isset($_SESSION['name'])) { // Если пользователь авторизован
    $user->willRead(); // Вызов функции вывода каталога книг "Буду читать"
} else {
    header("Location: ../index.php");
}
