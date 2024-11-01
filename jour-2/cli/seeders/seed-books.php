<?php

$books = json_decode(file_get_contents(__DIR__ . '/data/books.json'), true);
foreach ($books as $book) {
    $stmt = $conn->prepare('REPLACE INTO books (`id`, `title`, `genre`) VALUES (?, ?, ?)');
    $stmt->bind_param("iss", $book['id'], $book['title'], $book['genre']);
    $stmt->execute();
}
