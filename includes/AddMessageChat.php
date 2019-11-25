<?php
session_start();
include_once 'functions.php';
$user = new User;
$chat = new Chat;
    $NameUser = $_SESSION['name']; 
	if (isset($_POST['InputMessage']) && !empty($_POST['InputMessage'])) {
        $InputMessage = $_POST['InputMessage'];
		$chat->AddMessageChat($NameUser, $InputMessage);
	}
?>