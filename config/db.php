<?php
    
    require_once 'config.php';

    try {
        $dsn         = "mysql:local=" . $host . "; dbname=" . $dbName;
        $pdo         = new PDO($dsn, $userName, $password);
    } catch (PDOException $ex) {
        die('Erreur : ' . $ex->getMessage());
    }
