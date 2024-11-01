<?php

require dirname(__DIR__) . '/init.php';

$user = get_user_by_id($_POST['user_id'] ?? 0);
if ($user === false) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die;
}

$_SESSION['auth'] = $user;
header('Location: ' . $_SERVER['HTTP_REFERER']);
