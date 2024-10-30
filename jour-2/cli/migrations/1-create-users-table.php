<?php

$queries = <<<SQL
    CREATE TABLE `users` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(255) NOT NULL,
        `email` VARCHAR(255) NOT NULL,

        PRIMARY KEY (`id`)
    );
SQL;

$conn->multi_query($queries);
while ($conn->next_result()) {
}
echo 'Le tableau `users` a ete cree avec success.' . PHP_EOL;
