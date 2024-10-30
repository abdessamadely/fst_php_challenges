<?php

$queries = <<<SQL
    DROP TRIGGER IF EXISTS `inc_popularity_score_when_reserved`;
    DROP TABLE IF EXISTS `reservations`;
    DROP TABLE IF EXISTS `books`;
    DROP TABLE IF EXISTS `users`;
SQL;

$conn->multi_query($queries);
while ($conn->next_result()) {
}
echo 'Les tableaux et triggers a ete supprimer avec success.' . PHP_EOL;
