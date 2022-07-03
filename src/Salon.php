<?php

class Salon
{
    public static function dbQuery(): bool|PDOStatement
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        return $db->query("SELECT * FROM salon");
    }

    public static function getInformation()
    {
        $result = self::dbQuery();
        if (!$result){
            echo "BŁĄD w zapytaniu";
            exit;
        }
        return $result;
    }
}
