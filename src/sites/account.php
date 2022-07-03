<?php
session_start();
if (!isset($_SESSION['user'])){header("Location: login.php");}

include_once "../Page_element.php";
include_once "../Account.php";
include_once "../Booking.php";

$user_info = Account::get($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Konto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous">
</head>
<body>
    <?php Page_element::navbar()?>
    <div class="container-fluid mt-5 mb-5">
        <div class="row">
            <div class="col-sm-2">
                <div class="row">
                    <h1 class="h5 mb-3">Konto</h1>
                </div>
                <div class="col-6">
                    <div class="row">
                        <p><?php echo $user_info['firstname']?></p>
                    </div>
                    <div class="row">
                        <p><?php echo $user_info['email']?></p>
                    </div>
                    <div class="row">
                        <p><?php echo $user_info['phone']?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <h1 class="h3 row justify-content-center">Wizyty</h1>
                <div class="row">
                    <div class="col-xl-6">
                        <h2 class="h5 text-center">Nadchodzące</h2>
                        <?php
                        $future_books = Booking::getUsersFutureBooks($user_info['email']);
                        if(!empty($future_books[0])){ ?>
                            <table class="table bg-light">
                        <?php foreach ($future_books as $book){?>
                                <tr>
                                    <td>
                                        <?php echo $book['name']?>
                                    </td>
                                    <td>
                                        <?php echo $book['term']?>
                                    </td>
                                    <?php if(!$book['confirmed']){ ?>
                                    <td>
                                        <a href="edit_book.php?id=<?php echo $book['id']?>" class="btn btn-outline-warning btn-sm">EDYTUJ</a>
                                    </td>
                                    <td>
                                        <a href="conf_cancel_book.php?id=<?php echo $book['id']?>" class="btn btn-outline-danger btn-sm">ANULUJ</a>
                                    </td>
                                    <?php } else {?>
                                    <td></td>
                                    <td></td>
                                <?php } ?>
                                </tr>
                            <?php }?>
                            </table>
                        <?php }?>
                    </div>
                    <div class="col-md-1"></div>
                    <div  class="col-xl-5">
                        <h2 class="h5 text-center">Zakończone</h2>
                        <?php
                        $reservations = Booking::getUsersPreviousBooks($user_info['email']);
                        if(!empty($reservations[0])){ ?>
                            <table class="table  bg-light">
                                <?php foreach ($reservations as $book){?>
                                <tr>
                                    <td>
                                        <?php echo $book['name']?>
                                    </td>
                                    <td>
                                        <?php echo $book['term']?>
                                    </td>
                                    <?php
                                        if($book['confirmed'] == -1) {
                                            echo "<td>";
                                            echo "anulowana";
                                            echo "</td>";
                                        } else {
                                            echo "<td></td>";
                                        }
                                    ?>
                                </tr>
                                <?php } ?>
                            </table>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
