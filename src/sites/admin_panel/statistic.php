<?php
session_start();
include_once "../../Account.php";
include_once "../../Page_element.php";
include_once "../../Booking.php";
include_once "../../Client.php";

if(!isset($_SESSION['user'])) {
    header("Location: ../login.php");
}
if(Account::getRole($_SESSION['user'])!='admin') {
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Staystyki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous">
</head>
<body>
<?php Page_element::navbar()?>
<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-2 border bg-light">
            <?php Page_element::adminSidebar();?>
        </div>
        <div class="col-1"></div>
        <div class="col-6 justify-content-center">
            <div>
                <h1 class="h3 text-center">Statystyki klientów</h1>
            </div>
            <table class="table mt-4">
                <thead class="text-nowrap">
                    <tr>
                        <th scope="col">Imię</th>
                        <th scope="col">Nazwisko</th>
                        <th scope="col">e-mail</th>
                        <th scope="col">Łączna kwota</th>
                        <th scope="col">Ilość wizyt</th>
                        <th scope="col">Średnia cena</th>
                        <th scope="col">Średni czas usługi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $emails = Account::getEmails();
                    if(!empty($emails[0])){
                        foreach ($emails as $email){
                            $name = Account::getName($email[0]);
                            $client = new Client($name['firstname'],$name['lastname'],$email[0]);
                            $visits = Booking::getInfoToStats($email[0]);
                            if(!empty($visits[0])) {
                                $client->setCountOfVisits(count($visits));
                                foreach ($visits as $visit){
                                    $client->setTotalCost($visit['price']);
                                    $client->setTotalDuration(($visit['duration']));
                                }
                            }
                            $clients[] = $client;
                        }
                        foreach ($clients as $client){
                        ?>
                        <tr>
                            <td><?php echo $client->getFirstname() ?></td>
                            <td><?php echo $client->getLastname() ?></td>
                            <td><?php echo $client->getEmail() ?></td>
                            <td class="text-center"><?php echo $client->getTotalCost() ?></td>
                            <td class="text-center"><?php echo $client->getCountOfVisits() ?></td>
                            <?php if($client->getCountOfVisits()>0){ ?>
                                <td class="text-center"><?php echo round($client->getTotalCost()/$client->getCountOfVisits(),2) ?></td>
                                <td class="text-center"><?php echo round($client->getTotalDuration()/$client->getCountOfVisits(),2) ?></td>
                            <?php } else {?>
                                <td></td>
                                <td></td>
                        </tr>
                    <?php }}} ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
