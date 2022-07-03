<?php
session_start();
include_once "../Page_element.php";
include_once "../Salon.php";
include_once "../Service.php";
include_once "../Opinion.php"
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Barber shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
</head>
<body>
<?php
    Page_element::navbar();
    $salon = Salon::getInformation();
?>
    <div class='container-md mt-5 mb-5'>
<?php  while($row = $salon->fetch()) { ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <h1 class="h4">O nas:</h1>
                        <p>
                            <i class="bi bi-info-square-fill"></i>
                            <?php echo $row['description'] ?>
                        </p>
                        <p>
                            <i class="bi bi-geo-alt-fill"></i>
                            Znajdujemy się przy <?php echo $row['address'] ?>
                        </p>

                    </div>
                    <div class="row">
                        <iframe src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2282.9570608319787!2d18.6503086158458!3d54.35086338020173!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46fd739fe43849e1%3A0x47f495b1c5d0ebb2!2zWsWCb3RuaWvDs3cgMjEsIDgwLTgzNCBHZGHFhHNr!5e1!3m2!1spl!2spl!4v1653848332056!5m2!1spl!2spl'
                                class="container-fluid" allowfullscreen='' loading='lazy' referrerpolicy='no-referrer-when-downgrade'></iframe>
                    </div>
                </div>
                <?php
                preg_match_all("/[0-9]{2}/",$row['open_m_f'],$open,);
                preg_match_all("/[0-9]{2}/",$row['close_m_f'],$close);
                ?>
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div class="row">
                        <h2 class="h5">Godziny otwarci:</h2>
                        <ul>
                        <li>poniedziałek-piątek: <?php echo "{$open[0][0]}:{$open[0][1]} - {$close[0][0]}:{$close[0][1]}"?></li>
                        <?php
                        preg_match_all("/[0-9]{2}/",$row['open_sat'],$open,);
                        preg_match_all("/[0-9]{2}/",$row['close_sat'],$close);
                        ?>

                            <li>sobota: <?php echo "{$open[0][0]}:{$open[0][1]} - {$close[0][0]}:{$close[0][1]}"?></li>
                        <?php
                        if($row['open_sun'] != NULL && $row['close_sun'] != NULL){
                            preg_match_all("/[0-9]{2}/",$row['open_sun'],$open,);
                            preg_match_all("/[0-9]{2}/",$row['close_sun'],$close);
                            ?>
                            <li>niedziela: <?php echo "{$open[0][0]}:{$open[0][1]} - {$close[0][0]}:{$close[0][1]}"?> </li>;
                        <?php } else { ?>
                            <li>niedziela: nieczynne</li>
                        </ul>
                        <?php } ?>
                    </div>

                <?php
                }
                $services = Service::display2();
                ?>
                <div class="row mt-4">
                    <h3 class="h5">Usługi</h3>
                    <table class="table ">
                        <?php while ($result = $services->fetch()){ ?>
                            <tbody class="row-cols-xs-1">
                                <tr class="col">
                                        <td  class="col-md-5">
                                            <b><?php echo $result['name']?></b>
                                        </td>
                                        <td  class="col-md-3">
                                            <div class="col text-end">
                                                <div><?php echo $result['price'] . "zł"?></div>
                                                <div><?php echo $result['duration'] . " minut"?></div>
                                            </div>
                                        </td>
                                        <td  class="col-1">
                                            <a class="btn btn-primary" href="calendar.php?<?php echo 'id='.$result['id']?>" role="button">Umów</a>
                                        </td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
        </div>
    </div>
    <?php
    $result = Opinion::getOpinions();
    if(!empty($result[0])) { ?>
    <div class="mb-5 bg-light">
        <div class="row mt-4">
            <h2 class="h5 mt-3 mx-3">Opinie:</h2>
        </div>
            <table class="table">
                <?php
                for ($i = 0; $i < 3; $i++) {
                    $opinion = $result[$i];
                ?>
                    <tbody class="row mt-3 justify-content-center">
                        <tr class="col-10">
                            <td class="col-md-5">
                                <div class="row">
                                    <?php echo $opinion["name"]?>
                                </div>
                                <div class="row">
                                    <?php echo $opinion["date"]?>
                                </div>
                            </td>
                            <td class="col-1"></td>
                            <td class="col-md-6 text-sm-justify">
                                <?php echo $opinion["message"]?>
                            </td>
                        </tr>
                    </tbody>
<?php           }
    }?>
            </table>
        </div>
        <?php
        Opinion::newOpinion();
    if (!empty($_POST)) {
        Opinion::addToDB();
        header("Location: index.php");
    }
?>
    </div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
