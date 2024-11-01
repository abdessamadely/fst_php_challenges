<?php

require dirname(__DIR__) . '/init.php';

$user = $_SESSION['auth'];
$book = get_book_by_id($_POST['book_id'] ?? 0);

if ($user === false || $book === false || is_book_reserved($user['id'], $book['id'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die;
}

reserve_book($user['id'], $book['id']);

header('Location: ' . $_SERVER['HTTP_REFERER']);
