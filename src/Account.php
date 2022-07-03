<?php

class Account
{
    public static function validation($data) : string|bool
    {

        if(count($data)==6 || count($data)==7){
            $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
            $firstname = preg_replace("/\s/","",$data["firstname"]);
            $lastname = preg_replace("/\s/","",$data["lastname"]);
            if (!preg_match("/^[[:graph:]]*$/u",$firstname)){
                return "Nieprawidłowe dane!";
            }
            if(!preg_match("/^[[:graph:]]*$/u",$lastname)){
                return "Nieprawidłowe dane!";
            }
            if(!preg_match("/[.[:alnum:]]+@[[:alnum:]]+(\.[[:alnum:]]+)+/",$data['email'])) {
                return "Nieprawidłowy e-mail!";
            } else if ($db->query("SELECT * FROM accounts WHERE email Like '{$_POST['email']}'")->fetch()) {
                return "Podany email jest już zajęty!";
            }
            if(!empty($data['phone'])){
                $phone = preg_replace("/(\+48)?[ :\-;]*/","",$data['phone']);
                if(!preg_match("/^[0-9]{9}$/",$phone)){
                    return "Nieprawidłowy numer telefonu!";
                } else if($db->query("SELECT * FROM accounts WHERE phone Like '$phone'")->fetch()){
                    return "Podany numer telefonu jest już zajęty!";
                }
            }
            if(strlen($data['password'])<6){
                return "Hasło jest za krótkie!";
            } else if($data['password'] != $data['repeat_password']) {
                return "Wprowadzone hasła różnią się!";
            } else {
                if (!preg_match("/[A-Z]/", $data['password'])
                    && !preg_match("/[0-9]/", $data['password'])
                    && !preg_match("/\W/", $data['password'])
                    && preg_match("/\s/", $data['password'])) {
                    return "Nieprawidłowe hasło!";
                }
            }
        }
        return 0;
    }

    public static function addToDB($data) : string|bool
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $db->beginTransaction();
        try{
            $pass = password_hash($data['password'], PASSWORD_BCRYPT);
            $statement = $db->prepare("INSERT INTO accounts(email, firstname, lastname, phone, passwordHash) VALUE (?,?,?,?,?)");
            $statement->execute(array(
                $data['email'],
                $data['firstname'],
                $data['lastname'],
                $data['phone'],
                $pass,
            ));
            $db->commit();
            return 0;
        } catch (Exception $e){
            $db->rollBack();
            return $e;
        }
    }

    public static function login($mail, $pass): bool
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        if(preg_match("/[.[:alnum:]]+@[[:alnum:]]+(\.[[:alnum:]]+)+/",$mail)) {
            $passHash = $db->query("SELECT passwordHash FROM accounts WHERE email like '$mail'")->fetch()[0];
            return password_verify($pass, $passHash);
        }
        return 0;
    }

    public static function get(string $email): array|bool
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $sql = "SELECT email, firstname, lastname, phone FROM accounts WHERE email = ?";
        $query = $db->prepare($sql);
        $query->execute(array($email));
        if ($query->rowCount())
            return $query->fetch();
        return array(array());
    }

    public static function getRole($email)
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $sql = "SELECT role FROM accounts WHERE email = ?";
        $query = $db->prepare($sql);
        $query->execute(array($email));
        if ($query->rowCount()) {
            return $query->fetch()[0];
        }
        return 0;
    }

    public static function getName($email)
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $sql = "SELECT firstname, lastname FROM accounts WHERE email = ?";
        $query = $db->prepare($sql);
        $query->execute(array($email));
        if ($query->rowCount()) {
            return $query->fetch();
        }
        return 0;
    }

    public static function getEmails()
    {
        $db = new PDO($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPASS']);
        $result = $db->query("SELECT email FROM accounts WHERE role LIKE 'user'")->fetchAll();
        if (!$result){
            return array(array());
        }
        return $result;
    }
}
