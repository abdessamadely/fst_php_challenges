<?php

require dirname(__DIR__) . '/lib/database.php';

require __DIR__ . '/migrations/0-cleanup.php';
require __DIR__ . '/migrations/1-create-users-table.php';
require __DIR__ . '/migrations/2-create-books-table.php';
require __DIR__ . '/migrations/3-create-reservations-table.php';

require __DIR__ . '/seeders/seed-users.php';
require __DIR__ . '/seeders/seed-books.php';
