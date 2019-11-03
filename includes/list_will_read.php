<?php
session_start();
include_once 'functions.php';
$user = new User;

if (isset($_SESSION['name'])) {
    include_once 'header.php';
    $book_id = $_GET['id'];
    ?>
    <div class="wrapper">
        <section class="books">
            <h1 class="title" style="margin-bottom: 50px;">Буду читать позже</h1>
            <div class="books__list">
                <?php $user->willRead(); // Вызов функции для вывода списка книг "читать позже" 
                    ?>
            </div>
        </section>
    </div>
    </body>

    </html>
<?php } else {
    header("Location: ../index.php");
} ?>