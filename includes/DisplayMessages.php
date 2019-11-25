<?php
session_start();
include_once 'functions.php';
$user = new User;
$chat = new Chat;
$chat->MessageOutput();
