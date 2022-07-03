<?php

class Opinion
{
    public static function getOpinions() : array
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $result = $db->query("SELECT * FROM opinions ORDER BY date DESC");
        if ($result){
            return $result->fetchAll();
        }
        return array(array());
    }

    public static function newOpinion()
    {
        echo "<h2 class='h5'>Dodaj nową opinnię:</h2>";
        echo "<div class='container mt-4'>";
            echo "<div class='row-cols-md-2'>";
                echo "<p>Opinia:</p>";
                echo "<textarea name='message' form='opinion' required placeholder='Twoja opinia...' class='container-fluid'></textarea><br>";
                echo "<form method='post' id='opinion'>";
                echo    "<label for='name' class='mt-2'>Imię:</label><br>";
                echo    "<input type='text' class='mt-1' name='name' id='name' required placeholder='Imię'><br>";
                echo    "<input type='submit' class='btn btn-primary mt-3' name='send' id='send' value='PRZEŚLIJ OPINNIĘ'>";
                echo "</form>";
            echo "</div>";
        echo "</div>";
    }

    public static function addToDB()
    {
        if(!preg_match("/<script.*>/",$_POST['message']) && !preg_match("/<script.*>/",$_POST['name'])) {
            $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
            $statement = $db->prepare("INSERT INTO opinions(name, message, date) VALUE (?,?,?)");
            $statement->execute(array(
                $_POST["name"],
                $_POST["message"],
                date("Y-m-d H:i:s", time()),
            ));
        }
    }
}