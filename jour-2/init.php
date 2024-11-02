<?php

session_start();

require __DIR__ . '/lib/helpers.php';
require __DIR__ . '/lib/database.php';
require __DIR__ . '/lib/repository.php';

define('LOGGED_IN', !empty($_SESSION['auth']));
define('GUEST_URIS', ['/', '/actions/login.php']);
define('RESERVED_BOOKS', LOGGED_IN ? array_column(get_reserved_books($_SESSION['auth']['id']), 'id_book') : []);

if (!in_array($_SERVER['REQUEST_URI'], GUEST_URIS) && !LOGGED_IN) {
    header('Location: /');
    die;
}
