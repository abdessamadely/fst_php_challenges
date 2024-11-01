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
