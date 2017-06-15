<?php

include_once('dbconnect.php');


$result = pg_exec($conn, "SELECT * FROM usuarios");


?>
    <!DOCTYPE html>
    <html>

    <head>
        <title> Listado de Usuarios</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="js/jquery-3.2.1.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">

        <script src="js/getAPI.js"></script>
        <script>
            function buscar_usuario() {
                var valor_enviar = $('#buscador').val();
                console.log(valor_enviar.length);
                if (valor_enviar.length > 0) {
                    $(document).ready(function() {
                        $.post("usuarios_search_getter.php", {
                                name: valor_enviar
                            },
                            function(data, status) {
                                $('#resultados').html(data);
                            });
                    });
                } else {
                    $('#resultados').html('');
                }
            }

        </script>

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
                            <li><a href="stats.php">Ver Stats</a></li>
                        </ul>

                        <?php
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
                                <li><a href="mi_perfil.php"><span style="color:white"><?php echo $_SESSION['username']?> </span> </a></li>
                                <li><a href="logout.php">Logout</a></li>
                            </ul>

                            <?php
                        }
                        ?>

                    </div>
                </div>
            </nav>
        </div>

        <h1 align="center">Usuarios</h1>
        <div class="col-xs-4">
            <input type="text" id="buscador" class="form-control" placeholder="Buscar usuario" onkeyup="buscar_usuario()" align="right">
        </div>
        <div id="resultados" style="margin-left:120px;padding-left:5px;"></div>

        <table class="table table-striped">
            <tr class="active">
                <td>Username</td>
                <td>Nombres</td>
                <td> Equipo Favorito</td>
                <td>Jugador Favorito</td>
            </tr>
            <?php

            $todosDatos = array();

            $numrows = pg_numrows($result);
            for($i=0; $i < $numrows; $i++){
                $row = pg_fetch_array($result, $i);
                $todosDatos[] = $row;
            }

            $cantidadDatos = sizeof($todosDatos);

            for($i = 0; $i < $cantidadDatos; $i++){
            ?>
                <tr>
                    <td>
                        <a href="<?php echo $base_url; ?>/perfil_usuario.php?id=<?php echo $todosDatos[$i]['username']; ?>" title="<?php echo $todosDatos[$i]['username']; ?>">
                            <?php echo $todosDatos[$i]['username']; ?>
                        </a>
                    </td>

                    <td>
                        <?php echo $todosDatos[$i]['nombres']; ?> </td>

                    <td>
                        <?php echo $todosDatos[$i]['equipo']; ?> </td>

                    <td>
                        <?php echo $todosDatos[$i]['jugador']; ?> </td>
                </tr>

                <?php
            }
            ?>

        </table>


    </body>



    </html>
