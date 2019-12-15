<?php
session_start();
require_once 'functions.php';
$user = new User();
if (isset($_SESSION['name'])) { // Если пользователь авторизован
    $user->BooksViewed(); // Вызов функции вывода каталога книг "Просмотренные книги"
} else {
    header("Location: ../index.php");
}