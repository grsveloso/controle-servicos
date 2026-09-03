<?php

require_once __DIR__ . '/../Core/Database.php';

class Service
{
    public static function getServices()
    {
        $stmt = databaseConnection()->prepare("SELECT * FROM service");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $stmt = databaseConnection()->prepare("INSERT INTO service (description, price, user_id_user, created_at) VALUES (:description, :price, :user_id_user, NOW())");

        return $stmt->execute($data);
    }
}