<?php

function get_user_by_id($user_id)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows === 1 ? $result->fetch_assoc() : false;
}

function get_book_by_id($book_id)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM books WHERE id = ?');
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows === 1 ? $result->fetch_assoc() : false;
}

function get_grouped_books($limit_per_group = 10)
{
    global $conn;

    $books = [];
    $alphabet = 'abcdefghijklmnopqrstuvwxyz';
    foreach (str_split($alphabet) as $char) {
        $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ? LIMIT ?;");
        $pattern = "$char%";
        $stmt->bind_param("si", $pattern, $limit_per_group);
        $stmt->execute();
        $result = $stmt->get_result();
        $books_starts_by_char = $result->fetch_all(MYSQLI_ASSOC);
        $books[$char] = $books_starts_by_char;
    }

    return $books;
}

function is_book_reserved($user_id, $book_id)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM reservations WHERE id_user = ? AND id_book = ?');
    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}

function get_reserved_books($user_id, $cols = ['id_book'])
{
    global $conn;

    $allowed_cols = [
        'id_user',
        'id_book',
        'date_reservation',
    ];
    $columns = array_intersect($allowed_cols, $cols);

    $stmt = $conn->prepare('SELECT ' . join(', ', $columns) . ' FROM reservations WHERE id_user = ?');
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function reserve_book($user_id, $book_id)
{
    global $conn;

    $stmt = $conn->prepare('INSERT INTO reservations (`id_user`, `id_book`) VALUES (?, ?)');
    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
}
