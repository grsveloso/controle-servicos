<?php

require_once __DIR__ . '/../Core/Database.php';

class User
{
    public static function getUserByEmail($email)
    {
        $stmt = databaseConnection()->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $stmt = databaseConnection()->prepare("INSERT INTO user (name, email, password, ativo) VALUES (:name, :email, :password, 1)");

        return $stmt->execute($data);
    }
}