<?php
session_start();
require_once 'functions.php';
$user = new User();
$lastBook_id = $_POST['lastBook_id']; // id последней книги в списке из n количества выведенных
$user->AjaxBookOutput($lastBook_id); // Вызов функции вывода книг если была нажата кнопка "Ещё книги..." 