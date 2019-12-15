<?php
session_start();
require_once 'functions.php';
$user = new User();
$user->user_logout(); // Вызов функции выхода из аккаунта