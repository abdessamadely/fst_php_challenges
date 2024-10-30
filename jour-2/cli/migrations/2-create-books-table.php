<?php

$queries = <<<SQL
    CREATE TABLE `books` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `title` VARCHAR(255) NOT NULL,
        `genre` VARCHAR(255) NOT NULL,
        `popularity_score` INT DEFAULT 0,

        PRIMARY KEY (`id`)
    );
SQL;

$conn->multi_query($queries);
while ($conn->next_result()) {
}
echo 'Le tableau `books` a ete cree avec success.' . PHP_EOL;
