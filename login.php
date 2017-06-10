<?php
include_once('dbconnect.php');

if(isset($_POST['login_btn'])){
    //prepared statement
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    //$password = md5($password); hashing password

    $result = pg_exec($conn, "SELECT * FROM usuarios 
									WHERE username = '$username' AND password = '$password'");

    if(pg_numrows($result) == 1){
        $_SESSION['message'] = "Has ingresado a tu cuenta";
        $_SESSION['username'] = $username;
        header("location: index.php");
    }else{
        $_SESSION['message'] = "Username/password incorrecta";
    }
}

if(isset($_SESSION['message'])){
    $msj = $_SESSION['message'];
}else{
    $msj = "Ingresa a tu cuenta";
}

?>

    <!DOCTYPE html>
    <html>

    <head>
        <title> Login </title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="js/jquery-3.2.1.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">

        <link rel="stylesheet" href="css/login.css">
    </head>

    <body>

        <div class="navbar-wrapper">

            <nav class="navbar navbar-inverse navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="index.php">NFL</a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav nav-bar-left">
                            <li><a href="usuarios.php">Usuarios</a></li>
                            <li><a href="stats.php">Ver Stats</a></li>
                        </ul>

                        <?php if(!isset($_SESSION['username'])){ ?>
                        <ul class="nav navbar-nav nav-bar-right">
                            <li> <a href="register.php">Registrarse</a></li>
                        </ul>
                        <?php 
}
                                ?>
                    </div>
                </div>
            </nav>
        </div>


        <?php if(!isset($_SESSION['username'])){ ?>
        <form action="login.php" method="post" class="form-signin">
            <div class="container">
                <h2 class="form-signin-heading">
                    <?php  echo $msj;
                            unset($_SESSION['message']);
                            $msj = "";
                    ?>
                </h2>
                <input type="input" name="username" class="form-control" placeholder="Username" size="20" required>
                <input type="password" name="password" class=" form-control " size="20 " placeholder="Password" required>


                <button type="submit" name="login_btn" class="btn btn-lg btn-primary btn-block ">Ingresar</button>

            </div>
        </form>

        <?php 
                }
        ?>


    </body>


    </html>
