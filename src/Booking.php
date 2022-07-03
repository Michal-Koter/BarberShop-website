<?php

class Booking
{
    public static function getBooking(string $open, string $close): array
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $sql = "SELECT term, service_id, client_email, confirmed FROM booking WHERE confirmed NOT LIKE -1 AND term BETWEEN ? AND ? ORDER BY term";
        $query = $db->prepare($sql);
        $query->execute(array($open,$close));
        if ($query->rowCount())
            return $query->fetchAll();
        return array(array());
    }

    public static function getBookingToConfirm(): array
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $query = $db->query("SELECT booking.id as id, term, name, client_email
                FROM booking
                LEFT JOIN services s on s.id = booking.service_id
                WHERE confirmed=0
                ORDER BY booking.id DESC");
        if ($query->rowCount())
            return $query->fetchAll();
        return array(array());
    }

    public static function getVisits(string $open, string $close): array
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $sql = "SELECT booking.id as id, term, s.name as service, client_email 
                FROM booking 
                JOIN services s on s.id = booking.service_id 
                JOIN accounts a on a.email = booking.client_email 
                WHERE confirmed NOT LIKE -1 AND term BETWEEN ? AND ? 
                ORDER BY term";
        $query = $db->prepare($sql);
        $query->execute(array($open,$close));
        if ($query->rowCount()) {
            return $query->fetchAll();
        }
        return array(array());
    }

    public static function duration($id)
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $sql = "SELECT duration FROM services WHERE id = ?";
        $query = $db->prepare($sql);
        $query->execute(array($id));
        if ($query->rowCount()) {
            return $query->fetchAll()[0][0];
        }
        return 0;
    }

    public static function addToDB($term, $client, $service)
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $statement = $db->prepare("INSERT INTO booking(term, client_email, service_id) VALUE (?,?,?)");
        $statement->execute(array(
            $term,
            $client,
            $service
        ));
    }


    public static function getUsersFutureBooks($email): array|bool
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $sql = "SELECT booking.id, term, name , confirmed
                FROM booking
                left join services s on s.id = booking.service_id
                WHERE client_email LIKE ? AND term > CURRENT_TIMESTAMP AND confirmed!=-1";
        $query = $db->prepare($sql);
        $query->execute(array($email));
        if ($query->rowCount())
            return $query->fetchAll();
        return array(array());
    }

    public static function getUsersPreviousBooks($email): array|bool
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $sql = "SELECT booking.id as id, term, name, confirmed
                FROM booking
                left join services s on s.id = booking.service_id
                WHERE client_email LIKE ? AND term < CURRENT_TIMESTAMP";
        $query = $db->prepare($sql);
        $query->execute(array($email));
        if ($query->rowCount())
            return $query->fetchAll();
        return array(array());
    }

    public static function get($id)
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $sql = "SELECT * FROM booking WHERE id LIKE ?";
        $query = $db->prepare($sql);
        $query->execute(array($id));
        if ($query->rowCount())
            return $query->fetch();
        return array(array());
    }

    public static function updateTerm($id,$term)
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $statement = $db->prepare("UPDATE booking SET term=? WHERE id=?");
        $statement->execute(array(
            $term,
            $id
        ));
    }
public static function modifyConfirm(int $conf, int $id)
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $statement = $db->prepare("UPDATE booking SET confirmed=? WHERE id=?");
        $statement->execute(array(
            $conf,
            $id
        ));
    }

    public static function getInfoToStats($email): array|bool
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $sql = "SELECT duration, price
                FROM  services
                JOIN booking b on services.id = b.service_id
                WHERE client_email = ? AND confirmed NOT LIKE -1";
        $query = $db->prepare($sql);
        $query->execute(array($email));
        if ($query->rowCount()) {
            return $query->fetchAll();
        }
        return array(array());
    }
}