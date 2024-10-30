<?php

$queries = <<<SQL
    CREATE TABLE `reservations` (
        `id_user` INT NOT NULL,
        `id_book` INT NOT NULL,
        `date_reservation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,

        PRIMARY KEY (`id_user`, `id_book`),
        FOREIGN KEY (id_user) REFERENCES `users`(`id`),
        FOREIGN KEY (id_book) REFERENCES `books`(`id`)
    );

    CREATE TRIGGER `inc_popularity_score_when_reserved` AFTER INSERT ON `reservations`
    FOR EACH ROW
        BEGIN
            UPDATE `books` SET `popularity_score` = `popularity_score` + 1
            WHERE `id` = NEW.`id_book`;
        END;
SQL;

$conn->multi_query($queries);
while ($conn->next_result()) {
}
echo 'Le tableau `reservations` a ete cree avec success.' . PHP_EOL;
