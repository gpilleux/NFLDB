<?php 

	include_once('dbconnect.php');

?>

<!DOCTYPE html>
<html>

<head>
    <title> National Football League</title>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="js/jquery-3.2.1.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <link href="css/carousel.css" rel="stylesheet">

</head>

<body>
    <!-- Botones de navegacion -->
    <div class="navbar-wrapper">
        <div class="container">

            <nav class="navbar navbar-inverse navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="index.php">NFL</a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav nav-bar-left">
                            <li><a href="usuarios.php">Usuarios</a></li>
                            <li><a href="mi_perfil.php">Mi Perfil</a></li>
                            <li><a href="stats.php">Ver Stats</a></li>
                        </ul>

                        <?php 
			if(isset($_SESSION['message'])){ 
				echo $_SESSION['message'];
				unset($_SESSION['message']);
			}
			if(!isset($_SESSION['username'])){ echo "";
			?>

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="login.php">Ingresar</a></li>
                            <li><a href="register.php">Registrarse</a></li>
                        </ul>

                        <?php 
			}
			else{
			?>

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="mi_perfil.php"><span style="color:white">Bienvenido <?php echo $_SESSION['username']?> </span> </a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>

                        <?php
			}
			?>

                    </div>
                </div>
            </nav>

        </div>
    </div>
    <!-- /.Botones de Navegacion -->

    <!-- Carrusel-->
    <section class="block">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img class="first-slide" src="imgs/nfl2.jpg" alt="First slide">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1 align="center"> National Footbal League</h1>
                            <h4 align="center"> Sponsored by Fox Sport News</h4>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img class="second-slide" src="imgs/nfl3.png" alt="Second slide">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1 align="center"> <span style="color: black">National Footbal League</span></h1>
                            <h4 align="center"> <span style="color: black">Sponsored by Fox Sport News</span></h4>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img class="third-slide" src="imgs/nfl4.png" alt="Third slide">
                    <div class="container">
                    </div>
                </div>
            </div>
        </div>
        <div>
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>

    <!-- /.Carrusel -->
</body>


</html>
