<?php
session_start();
require_once 'functions.php';
$user = new User();
$chat = new Chat();
$NameUser = $_SESSION['name']; // Логин авторизованного пользователя
if (isset($_POST['InputMessage']) && !empty($_POST['InputMessage'])) { 
	// Если была отправка #InputMessage и поле не пустое, то выполнить отправку сообщения
	$InputMessage = $_POST['InputMessage'];
	$chat->AddMessageChat($NameUser, $InputMessage); // Вызов функции отправки сообщения
}