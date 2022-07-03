<?php

class Service
{
    public static function display2()
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $result = $db->query("SELECT * FROM services WHERE available=true");
        if (!$result){
            echo "BŁĄD w zapytaniu";
            exit;
        }
        return $result;
    }

    public static function display1($id): mixed
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $sql = "SELECT * FROM services WHERE id = ? AND available=true";
        $query = $db->prepare($sql);
        $query->execute(array($id));
        if ($query->rowCount())
            return $query->fetch();
        return "ERROR";
    }

    public static function getName($id) : string
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $sql = "SELECT name FROM services WHERE id = ? AND available=true";
        $query = $db->prepare($sql);
        $query->execute(array($id));
        if ($query->rowCount())
            return $query->fetch()[0];
        return "ERROR";
    }

    public static function update($price,$duration, $id)
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        if(!empty($price)){
            if(preg_match("/^[0-9]*([,.][0-9]{1,2})?$/",$price)){
                $sql = "UPDATE services SET price=? WHERE id=?";
                $query = $db->prepare($sql);
                $query->execute(array($price, $id));
            } else {
                echo "<div>Zmiana ceny usługi nie powiodła się!</div>";
            }
        }
        if(!empty($duration)){
            if(preg_match("/^[0-9]*$/",$duration)){
                $sql = "UPDATE services SET duration=? WHERE id=?";
                $query = $db->prepare($sql);
                $query->execute(array($duration, $id));
            } else {
                echo "<div>Zmiana trwania usługi nie powiodła się!</div>";
            }
        }
    }

    public static function delete($id)
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $sql = "UPDATE services SET available=false WHERE id=?";
        $query = $db->prepare($sql);
        $query->execute(array($id));
    }

    public static function addToDB($name, $price, $duration): int
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $sql = "SELECT * FROM services WHERE name LIKE ?";
        $query = $db->prepare($sql);
        $query->execute(array($name));
        $result = $query->fetch();
        if($result){
            echo "<div>Usługa o tej nazwie już istnieje</div>";
            return -1;
        }
        if(!preg_match("/^[[:alnum:] .,\/]*$/",$name)){
            echo "<div>Niepoprawna nazwa!</div>";
            return -1;
        }if(!preg_match("/^[0-9]*([,.][0-9]{1,2})?$/",$price)){
            echo "<div>Niepoprawna cena!</div>";
            return -1;
        }if(!preg_match("/^[0-9]*$/",$duration)){
            echo "<div>Niepoprawny czas!</div>";
            return -1;
        }
        $sql = "INSERT INTO services(name, price, duration) VALUE (?,?,?)";
        $query = $db->prepare($sql);
        $query->execute(array($name,$price,$duration));
        return 0;
    }
}

