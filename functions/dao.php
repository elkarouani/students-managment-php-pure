<?php 
    require_once "config/db.php";

    function getDatas($req, $params)
    {
        global $pdo;
        $stmt = $pdo->prepare($req);
        $stmt->execute($params);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getData($req, $params)
    {
        global $pdo;
        $stmt = $pdo->prepare($req);
        $stmt->execute($params);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    function setData($req, $params)
    {
        try {
            global $pdo;
            $stmt = $pdo->prepare($req);
            return $stmt->execute($params);
        } catch (Exception $e) {
            return $e;
        }
    }
