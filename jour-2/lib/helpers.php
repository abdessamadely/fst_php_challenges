<?php

function dd(...$data)
{
    echo '<pre>';
    foreach ($data as $item) {
        print_r($item);
        echo PHP_EOL;
    }
    echo '</pre>';
    die;
}
