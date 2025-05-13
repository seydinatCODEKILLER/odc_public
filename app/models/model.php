<?php

function connectDB()
{
    $host = 'localhost';
    $port = '5432';
    $dbname = 'odc_school';
    $username = 'postgres';
    $password = 'liverpool';

    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données PostgreSQL: " . $e->getMessage());
    }
}
