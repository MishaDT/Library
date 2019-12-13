<?php
session_start();
include_once 'functions.php';
$user = new User();
if (isset($_SESSION['name'])) {
    $user->willRead();
} else {
    header("Location: ../index.php");
}
