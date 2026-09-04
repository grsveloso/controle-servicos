<?php

require_once __DIR__ . '/../Core/Database.php';

class Service
{
    public static function getServices($dateStart = null, $dateEnd = null, $description = null, $status = null, $name = null)
    {
        $sql = "SELECT service.id_service, 
        service.description, service.price, service.status, user.name FROM service JOIN user ON service.user_id_user = user.id_user";

        $filter = [];

        if ($dateStart && $dateEnd) {
            $sql .= " WHERE service.created_at BETWEEN :date_start AND :date_end";
            $filter[':date_start'] = $dateStart;
            $filter[':date_end'] = $dateEnd;
        }

        if ($description !== null) {
            $sql .= " AND service.description LIKE :description";
            $filter[':description'] = "%$description%";
        }

        if ($status) {
            $sql .= " AND service.status = :status";
            $filter[':status'] = $status;
        }

        if ($name !== null) {
            $sql .= " AND user.name LIKE :name";
            $filter[':name'] = "%$name%";
        }

        $stmt = databaseConnection()->prepare($sql);
        $stmt->execute($filter);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getLastServices()
    {
        $stmt = databaseConnection()->prepare("SELECT * FROM service ORDER BY created_at DESC LIMIT 3");
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPendingServices()
    {
        $stmt = databaseConnection()->prepare("SELECT * FROM service WHERE status = 'PENDENTE' ORDER BY created_at DESC LIMIT 3");
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getServiceWithUser($serviceId)
    {
        $stmt = databaseConnection()->prepare("SELECT service.*, user.name, user.email FROM service JOIN user ON service.user_id_user = user.id_user WHERE service.id_service = :id_service");
        $stmt->bindParam(':id_service', $serviceId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $stmt = databaseConnection()->prepare("INSERT INTO service (description, price, commission_user, user_id_user, created_at) VALUES (:description, :price, :commission_user, :user_id_user, NOW())");

        return $stmt->execute($data);
    }

    public static function finishServices($serviceId)
    {
        $stmt = databaseConnection()->prepare("UPDATE service SET status = 'FINALIZADO', finished_at = NOW() WHERE id_service = :id_service");
        $stmt->bindParam(':id_service', $serviceId);
        
        return $stmt->execute();
    }

    public static function deleteService($serviceId)
    {
        $stmt = databaseConnection()->prepare("DELETE FROM service WHERE id_service = :id_service");
        $stmt->bindParam(':id_service', $serviceId);
        
        return $stmt->execute();
    }

    public static function getServiceById($serviceId)
    {
        $stmt = databaseConnection()->prepare("SELECT * FROM service WHERE id_service = :id_service");
        $stmt->bindParam(':id_service', $serviceId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateService($serviceId, $description, $price)
    {
        $stmt = databaseConnection()->prepare("UPDATE service SET description = :description, price = :price, update_at = NOW() WHERE id_service = :id_service");
        $stmt->bindParam(':id_service', $serviceId);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);

        return $stmt->execute();
    }

    public static function calculateCommision($price)
    {
        if($price <= 1000) {
            return $price * 0.05;
        } else if($price <= 10000) {
            return $price * 0.10;
        } else {
            return $price * 0.20;
        }
    }
}