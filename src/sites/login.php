<?php
    session_start();
    if(isset($_SESSION['user'])){
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous">
    <?php
        include_once "../Page_element.php";
        include_once "../Account.php";
    ?>
</head>
<body>
    <?php Page_element::navbar();?>
    <div class="container-xs justify-content-center mt-5">
        <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3 container-fluid border bg-light">
            <h1 class="h4 text-center mt-4">Logowanie</h1>
            <form method="post">
                <div class="row mt-3">
                    <label for="email">E-mail:</label>
                    <input type="text" required name="email" id="email" placeholder="login" class="col-md-10 container-fluid mt-2">
                </div>
                <div class="row mt-3">
                    <label for="password">Hasło:</label>
                    <input type="password" required name="password" id="password" placeholder="*****" class="col-md-10 container-fluid mt-2">
                </div>
                <div class="row mt-5 mb-4">
                    <input type="submit" name="submit" id="submit" value="ZALOGUJ SIĘ" class="btn btn-primary col-sm-8 container-fluid">
                </div>
            </form>
        </div>
    </div>
    <?php
    if(!empty($_POST)){
        if (Account::login($_POST['email'],$_POST['password'])){
            $_SESSION['user'] = $_POST['email'];
            $_SESSION['role'] = Account::getRole($_POST['email']);
            header("Location: index.php");
        } else {
            echo "<script type = 'text/javascript' >
                alert('Logowanie nie udane. Spróbuj ponownie!')
                window . location . href = 'login.php'
            </script >";
        }
    }
    ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>