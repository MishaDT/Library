<?php
session_start();
require_once 'functions.php';
$user = new User();
$output = '';
$video_id = '';
$que = "SELECT COUNT(*) as num_rows FROM books WHERE id < " . $_POST['last_video_id'] . "";
$res = $user->db->query($que) or die($user->error);
$ro = $res->fetch_array(MYSQLI_ASSOC);
$totalRowCount = $ro['num_rows'];
$showLimit = 9;
$query = "SELECT * FROM `books` WHERE id > " . $_POST['last_video_id'] . " LIMIT $showLimit";
$result = $user->db->query($query) or die($user->error);
if ($row = $result->num_rows > 0) {
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $video_id = $row["id"];
        $img = $row['img'];
        $title = $row['title'];
        $author = $row['author'];
        $output .= '<div class="books__item"> 
        <div class="item-books__img">
                <img src="../img/' . $img . '" alt="' . $title . '">
            </div>
                <h2 class="item-books__title">' . $title . '</h2>
                <span class="item-books__author">' . $author . '</span>';
        if (isset($_SESSION['name'])) {
            $output .= "<a href=\"includes/book_reading_page.php?id=$video_id\" class='item-books__button'>Читать</a>";
            $output .= "<a href=\"includes/i_will_read.php?id=$video_id?title=$title?author=$author\" style='text-decoration: underline; color: #000;' class='item-books__will_read'>Читать позже</a>";
        }
        $output .= '</div>';
    }
    if ($totalRowCount < $showLimit) {
        $output .= '<div id="remove_row"><button type="button" name="btn_more" data-vid="' . $video_id . '" id="btn_more" class="button__read_more form-control">Ещё книги...</button></div>';
    }
    $output .= '</div>';
    echo $output;
}
