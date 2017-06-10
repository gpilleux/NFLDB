<?php 
	include_once('dbconnect.php');


	if(!isset($_SESSION) || !isset($_SESSION['username'])){
        $_SESSION['message'] = "Ingresa a tu cuenta";
		header("Location: login.php");
        $_SESSION['message'] = "Ingresa a tu cuenta";
    }

    $username = htmlspecialchars($_SESSION['username']);

    if(isset($_POST['select_equipo'])){
        $equipo = htmlspecialchars($_POST['select_equipo']);
    
        $result = pg_query($conn, "UPDATE usuarios SET equipo = '".$equipo."' WHERE username =  '".$username."'");
        //dump the result object
        var_dump($result);
        $_SESSION['message'] = "Equipo actualizado exitosamente";
    }
    if(isset($_POST['select_perfil'])){
        $jugador = htmlspecialchars($_POST['select_perfil']);

        $result = pg_query($conn, "UPDATE usuarios SET jugador = '".$jugador."' WHERE username = '".$username."'");
        //dump the result object
        var_dump($result);
        $_SESSION['message'] = "Perfil y jugador actualizados exitosamente";
    }

	#Datos del participante
	$result = pg_exec($conn, "SELECT * FROM usuarios 
									WHERE username = '$username' ");
	$row = pg_fetch_array($result, 0);

	$username = $row['username'];
	$nombres = $row['nombres'];
    $jugador = $row['jugador'];
    $equipo = $row['equipo'];
	$biografia = $row['biografia'];

    if(isset($_SESSION['message'])){
        $msj = $_SESSION['message'];
    }else{
        $msj = "Personaliza tu perfil";
    }
    
?>

<!DOCTYPE html>
<html>

<head>
    <title> Mi Perfil</title>
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
        
        nav {
            padding-right: 20px;
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
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="mi_perfil.php"><span style="color:white"> <?php echo $_SESSION['username']?> </span> </a></li>
                        <li><a href="logout.php">Logout</a></li>
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


    <form action="mi_perfil.php" method="POST">
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

                <td><input type="text" name="buscar_perfil" placeholder="Busque su jugador favorito" size="25" onkeyup="predictionsPerfil()"></td>

                <td>
                    <div id="resultados_perfil" style="margin-left:120px;padding-left:5px;"></div>
                </td>


            </tr>
            <tr>
                <td>Equipo Favorito</td>
                <td>
                    <?php print($equipo); ?>
                </td>

                <td><input type="text" name="buscar_equipo" placeholder="Busque su equipo favorito" size="25" onkeyup="predictionsEquipo();"> </td>

                <td>
                    <div id="resultados_equipos" style="margin-left:120px;padding-left:5px;"></div>
                </td>
            </tr>
            <tr>
                <td> Biografia</td>
                <td>
                    <?php print_r($biografia) ?>
                </td>
            </tr>
        </table>

    </form>
</body>

<script>
    function llamar_otra_pagina_Perfil() {
        var texto = escapeHtml($('input[name="buscar_perfil"]').val());
        var process = function(response) {
            $('#resultados_perfil').html(response);
        }

        getAPI("<?php echo $base_url; ?>/name_search_getter.php?name=" + texto, process);
    }

    function predictionsPerfil() {
        if ($('input[name="buscar_perfil"]').val().length >= 3) {
            llamar_otra_pagina_Perfil();
        } else {
            $('#resultados_perfil').html('');
        }
    }

    function llamar_otra_pagina_Equipo() {
        var texto = escapeHtml($('input[name="buscar_equipo"]').val());

        var process = function(response) {
            $('#resultados_equipos').html(response);
        }

        getAPI("<?php echo $base_url; ?>/team_search_getter.php?name=" + texto, process);
    }

    function predictionsEquipo() {
        if ($('input[name="buscar_equipo"]').val().length >= 1) {
            llamar_otra_pagina_Equipo();
        } else {
            $('#resultados_equipos').html('');
        }
    }

    function escapeHtml(text) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };

        return text.replace(/[&<>"']/g, function(m) {
            return map[m];
        });
    }

</script>


</html>

<?php



?>
