<?php

session_start();

require __DIR__ . '/lib/database.php';
require __DIR__ . '/lib/repository.php';

define('LOGGED_IN', !empty($_SESSION['auth']));
define('GUEST_URIS', ['/', '/login.php']);

if (!in_array($_SERVER['REQUEST_URI'], GUEST_URIS) && !LOGGED_IN) {
    header('Location: /');
    die;
}
