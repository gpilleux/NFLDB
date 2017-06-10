<?php 
	include_once('dbconnect.php');

    if(isset($_GET)){
        $username = $_GET['id'];

        #Datos del participante
        $result = pg_exec($conn, "SELECT * FROM usuarios 
                                        WHERE username = '$username' ");
        
        if(pg_numrows($result) > 0){
            $row = pg_fetch_array($result, 0);

            $username = $row['username'];
            $nombres = $row['nombres'];
            $jugador = $row['jugador'];
            $equipo = $row['equipo'];
            $biografia = $row['biografia'];
        }else{
            $_SESSION['message'] = "Ese usuario no existe";
        }
    }
    if(isset($_SESSION['message'])){
        $msj = $_SESSION['message'];
    }else{
        $msj = "";
    }

?>



<!DOCTYPE html>
<html>

<head>
    <title> Perfil ajeno</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="js/jquery-3.2.1.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">

    <script src="js/getAPI.js"></script>

    <style>
        body {
            background-color: lightgray;
        }

    </style>

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
                </div>
            </div>
        </nav>
    </div>
    <div>
        <h3>
            <?php 
                echo $msj;
                $msj = "";
                unset($_SESSION['message']);
        ?>
        </h3>
    </div>
    <table class="table table-striped table-hover">
        <tr>
            <td>Username</td>
            <td>
                <?php print($username) ?>
            </td>
        </tr>

        <tr>
            <td>Nombres</td>
            <td>
                <?php print($nombres) ?>
            </td>
        </tr>
        <tr>
            <td>Jugador Favorito</td>
            <td>
                <?php print($jugador); ?>
            </td>
            <tr>
                <td>Equipo Favorito</td>
                <td>
                    <?php print($equipo); ?>
                </td>
            </tr>

            <tr>
                <td> Biografia</td>
                <td>
                    <?php print_r($biografia) ?>
                </td>
            </tr>

    </table>

</body>


</html>
