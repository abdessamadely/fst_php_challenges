<?php

$users = json_decode(file_get_contents(__DIR__ . '/data/users.json'), true);
foreach ($users as $user) {
    $stmt = $conn->prepare('REPLACE INTO users (`id`, `name`, `email`) VALUES (?, ?, ?)');
    $stmt->bind_param("iss", $user['id'], $user['name'], $user['email']);
    $stmt->execute();
}
