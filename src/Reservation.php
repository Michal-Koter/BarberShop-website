<?php

include_once "Salon.php";

class Reservation
{
    public static function openHours() : array
    {
        $result = Salon::dbQuery();
        if (!$result){
            echo "BŁĄD w zapytaniu";
            exit;
        }
        $row = $result->fetch();
        $days = ['m_f','sat','sun'];
        $hours = array();
        foreach ($days as $day){
            if($row["open_$day"] != null && $row["close_$day"] != null) {
                $open = new DateTime("{$row["open_$day"]}");
                $close = new DateTime("{$row["close_$day"]}");
                $hours[] = [$open, $close];
            }
        }
        return $hours;
    }
}
