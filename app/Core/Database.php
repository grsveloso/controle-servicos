<?php

function databaseConnection() 
{
    $hostname = "localhost";
    $username = "root";
    $password = "tse_jm@1,#";
    $database = "jm_informatica";

    $dsn = "mysql:host=$hostname;dbname=$database;charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erro na conexão com o banco de dados: " . $e->getMessage());
    }
}
?>