<?php

/**
 * Create a new MySQL connection to our Library database
 */
$port = 3306;
$hostname = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'library';

// Cree la base de donnes dans le case ou il n'exist pas
$mysql = mysqli_connect($hostname, $username, $password);
$database_count = mysqli_query($mysql, "SHOW DATABASES WHERE `Database` = '$database';");
if ($database_count->num_rows === 0) {
    mysqli_query($mysql, "CREATE DATABASE $database;");
}

$conn = new mysqli($hostname, $username, $password, $database, $port);

/**
 * Check if there's any any connection error 
 */
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
