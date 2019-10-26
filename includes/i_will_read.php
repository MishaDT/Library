<?php
session_start();
include_once 'functions.php';
$user = new User;

if (isset($_SESSION['name'])) {
    $id = $_GET['id'];
    $uid = $_SESSION['uid'];
    $title = $_GET['title'];
    $author = $_GET['author'];
    $read = $user->addToWillRead($id, $uid, $title, $author);
    if (!$read) {
        header("Location: ../index.php");
    } else {
        header("Location: ../index.php");
    }
} else {
    return false;
    header("Location: ../index.php");
}