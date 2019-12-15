<?php
session_start();
require_once 'functions.php';
$user = new User();
$chat = new Chat();
$chat->MessageOutput(); // Вызов функции вывода сообщений