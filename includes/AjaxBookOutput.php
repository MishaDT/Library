<?php
session_start();
require_once 'functions.php';
$user = new User();
$last_video_id = $_POST['last_video_id'];
$user->AjaxBookOutput($last_video_id);
