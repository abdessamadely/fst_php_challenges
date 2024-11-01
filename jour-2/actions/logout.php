<?php

require dirname(__DIR__) . '/init.php';

unset($_SESSION['auth']);
header('Location: /');
die;
