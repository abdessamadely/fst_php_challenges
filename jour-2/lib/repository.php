<?php

function get_user_by_id($user_id)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM users WHERE id = ?;');
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows === 1 ? $result->fetch_assoc() : false;
}

function get_grouped_books()
{
    global $conn;

    $books = [];
    $alphabet = 'abcdefghijklmnopqrstuvwxyz';
    foreach (str_split($alphabet) as $char) {
        $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ?;");
        $pattern = "$char%";
        $stmt->bind_param("s", $pattern);
        $stmt->execute();
        $result = $stmt->get_result();
        $books_starts_by_char = $result->fetch_all(MYSQLI_ASSOC);
        $books[$char] = $books_starts_by_char;
    }

    return $books;
}
