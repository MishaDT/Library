<?php
session_start();
require_once 'functions.php';
$user = new User();
if (isset($_SESSION['name'])) { // Если пользователь авторизован
    $user->readTheBook(); // Вызов функции вывода каталога книг "Прочитанные книги" 
} else {
    header("Location: ../index.php");
}
