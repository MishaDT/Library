<?php

session_start();

if (isset($_SESSION['name'])) {

    include_once 'functions.php';
    include_once 'header.php';
    $user = new User;

    if (isset($_GET['id']) || isset($_GET['users_id'])) { ?>
        <div class="wrapper">
            <section class="books">
                <?php $id = $_GET['id'];
                $users_id = $_GET['users_id'];
                        $uid = $_SESSION['uid'];
                        $title = $_GET['title'];
                        $author = $_GET['author'];
                        $user->bookReadingPage($id, $users_id);
                        $user->addToReadList($id, $uid);
                        ?>
            </section>
        </div>

<?php
    }
} else {
    header("Location: ../index.php");
}
