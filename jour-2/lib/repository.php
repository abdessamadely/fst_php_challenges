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

function get_favorite_genres($user_id)
{
    global $conn;

    $stmt = $conn->prepare(<<<SQL
        SELECT books.genre, COUNT(*) as reserved_times FROM books
        JOIN reservations ON reservations.id_book = books.id
        WHERE reservations.id_user = ?
        GROUP BY books.genre
        ORDER BY reserved_times
    SQL);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_suggested_books($user_id, $limit_per_genre = 6)
{
    global $conn;

    $suggested_books = [];
    $favorite_genres = get_favorite_genres($user_id);

    foreach ($favorite_genres as $favorite_genre) {
        $stmt = $conn->prepare(<<<SQL
            SELECT * FROM books
            WHERE genre = ?
            AND id NOT IN (
                SELECT id_book FROM reservations WHERE id_user = ?
            )
            ORDER BY popularity_score DESC
            LIMIT ?;
        SQL);

        $stmt->bind_param("sii", $favorite_genre['genre'], $user_id, $limit_per_genre);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            continue;
        }

        $suggested_books[] = [
            'genre' => $favorite_genre['genre'],
            'books' => $result->fetch_all(MYSQLI_ASSOC),
            'reserved_times' => $favorite_genre['reserved_times'],
        ];
    }

    usort($suggested_books, fn($a, $b) => $b['reserved_times'] <=> $a['reserved_times']);

    return $suggested_books;
}

function get_popular_books($duration = '1 minute')
{
    $start_date = (new DateTime())->sub(DateInterval::createFromDateString($duration));

    return [];
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

function reserve_book($user_id, $book_id)
{
    global $conn;

    $stmt = $conn->prepare('INSERT INTO reservations (`id_user`, `id_book`) VALUES (?, ?)');
    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
}
