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

            function llamar_otra_pagina() {
                var texto = escapeHtml($('input[name="buscador"]').val());

                var process = function(response) {
                    $('#resultados').html(response);
                }

                getAPI("<?php echo $base_url; ?>/usuarios_search_getter.php?name=" + texto, process);

            }

            function predictions() {
                if ($('input[name="buscador"]').val().length >= 1) {
                    llamar_otra_pagina();
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
        <input type="text" name="buscador" placeholder="Buscar usuario" onkeyup="predictions()" align="right">
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
