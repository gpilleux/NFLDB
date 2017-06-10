<!DOCTYPE html>

<?php

	include_once('dbconnect.php');
/*
$sql = 'select * from combine';
$result = pg_exec($conn, $sql);
  $numrows = pg_numrows($result);
  echo "<p>link = $conn<br>
  result = $result<br>
  numrows = $numrows</p>
  ";

 print_r(($row = pg_fetch_array($result, 0))); */
 
	if(isset($_POST['registrar'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		$nombres = $_POST['nombre'];
		$biografia = $_POST['biografia'];
		
        $result = pg_exec($conn, "SELECT * FROM usuarios WHERE username = '$username' ");
        $rows = pg_numrows($result);
        
        if($rows > 0 ){
            $_SESSION['message'] = "Ya existe ese usuario";
            //header("location: register.php");
        }else{
            
            if($password == $password2){
                // create user ... (verificar que no exista?)
                $result = pg_exec($conn, "INSERT INTO usuarios(username, password, nombres, biografia) 
                      VALUES('$username', '$password', '$nombres', '$biografia');");
                //dump the result object
                var_dump($result);
                $_SESSION['message'] = "Has ingresado a tu cuenta";
                $_SESSION['username'] = $username;
                header("location: index.php");
            }else{
                $_SESSION['message'] = "Las contraseñas no son iguales";
            }
        }
    }
    if(isset($_SESSION['message'])){
        $msj = $_SESSION['message'];
    }else{
        $msj = "¡Regístrate aquí!";
    }


?>

    <html>

    <head>
        <title> Creacion de cuenta</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="js/jquery-3.2.1.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">

        <link rel="stylesheet" href="css/register.css">

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
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="login.php">Ingresar</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <form action="register.php" method="post" class="form-signin">
            <div class="container">
                <h2 class="form-signin-heading">
                    <?php  echo $msj;
                            $msj = "";
                    ?>
                </h2>

                <input type="text" name="username" class="form-control" placeholder="Username" size="20" required>


                <input type="password" name="password" class=" form-control " size="20 " placeholder="Password" required>

                <input type="password" name="password2" class=" form-control " size="20 " placeholder="Password" required>

                <input type="text" name="nombre" class="form-control" placeholder="Nombres" size="10" required>


                <textarea rows="5" cols="38" name="biografia" maxlength="500" placeholder="Biografia">
					</textarea>

                <br><button type="submit" name="registrar" class="btn btn-sm btn-primary ">Registrarme</button>
            </div>

        </form>
    </body>


    </html>
