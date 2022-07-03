<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Opinie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous">
    <?php
        include_once "../Page_element.php";
        include_once "../Opinion.php";
    ?>
</head>
<body>
    <?php Page_element::navbar()?>
        <div class="container justify-content-center mt-5">
            <?php
            Opinion::newOpinion();
            if(!empty($_POST)){
                Opinion::addToDB();
                header("Location: index.php");
            }
            ?>
        </div>
    <?php
        $result = Opinion::getOpinions();
    ?>
        <div class="container mt-5 mb-5">
            <div class="">
                <h1 class="h3">Opinie użytkowników</h1>
            </div>
            <div class="d-flex justify-content-center ">
                <div class="col-md-9">
                <?php
                if(!empty($result[0])) {
                    foreach ($result as $opinion){ ?>
                        <div class="row mt-4 border bg-light">
                            <div class="col-sm-3 text-start mt-3">
                                <h2 class="h6"><?php echo $opinion["name"]?></h2>

                            </div>
                            <div class="col-9 text-end mt-3">
                                <?php echo $opinion["date"]?>
                            </div>
                            <div class="row">
                                <p class="fs-6"><?php echo $opinion["message"]?></p>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
                </div>
            </div>
        </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
