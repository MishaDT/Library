<?php
session_start();
require_once 'functions.php';
$user = new User();
if (isset($_SESSION['name'])) {
    $id = $_POST['id'];
    $uid = $_SESSION['uid'];
    $res = $user->deleteWillRead($id, $uid);
} else {
    header("Location: ../index.php");
}
