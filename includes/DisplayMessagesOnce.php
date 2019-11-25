<?php
session_start();
include_once 'functions.php';
$user = new User;
$chat = new Chat;
$chat->MessageOutput();
?>
<script type="text/javascript">
    $('#BlockMessage').scrollTop($('#BlockMessage')[0].scrollHeight);
</script>