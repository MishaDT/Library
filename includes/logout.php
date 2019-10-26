<?php 
session_start();
include_once 'functions.php';

$user = new User;
$user->user_logout();
header("Location: ../index.php");