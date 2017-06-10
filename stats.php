<?php
    
    include_once('dbconnect.php');

    if(isset($_POST['order_players'])){
        //traer la tabla con los siguientes valores
        $order = $_POST['order_players'];
        $orderBy = $_POST['order_by'];
        $limit = $_POST['show']; 
        
        $result = pg_exec($conn, "SELECT * FROM players $order $orderBy $limit ");
        if(pg_numrows($result) > 0)
            $row = pg_fetch_array($result, 0);
        $num_parametros = sizeof(array_keys($row));
        
        //print_r($row);
           
    }
    $equipos = pg_exec($conn, "SELECT name FROM shortnames");


?>

    <!DOCTYPE html>
    <html>

    <head>
        <title> Estadisticas </title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="js/jquery-3.2.1.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">

        <style>
            body {
                background-color: lightgray;
            }
            
            nav {
                padding-right: 20px;
            }

        </style>
        <script src="js/getAPI.js"></script>
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
                            <li><a href="mi_perfil.php">Mi Perfil</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <form method="POST" action="stats.php">
            <div>
                <span class="">Selección de jugadores</span>
            </div>
            <table class="table table-striped table-hover table-condensed">
                <tr>
                    <td>Ordenar por</td>
                    <td>De forma</td>
                    <td>Mostrar</td>
                </tr>
                <tr>
                    <td>
                        <select name="order_players">
                            <option value="ORDER BY name">Nombre</option>
                            <option value="ORDER BY birth_date">Fecha de nacimiento</option>
                            <option value="ORDER BY college">Instituto</option>
                            <option value="ORDER BY position">Posición</option>
                            <option value="ORDER BY height">Altura</option>
                            <option value="ORDER BY weight">Peso</option>
                            <option value="ORDER BY year_start">Año comienzo</option>
                            <option value="ORDER BY year_end">Año término</option>
                            <option value="ORDER BY year_end - year_start">Duración</option>
                        </select>
                    </td>
                    <td>
                        <select name="order_by">
                            <option value="ASC">Ascendiente</option>
                            <option value="DESC">Descendiente</option>
                        </select>
                    </td>

                    <td>
                        <select name="show">
                            <option value="LIMIT 10">10</option>
                            <option value="LIMIT 50">50</option>
                            <option value="LIMIT 100">100</option>
                            <option value="">Todo</option>
                        </select>
                    </td>

                    <td><button type="submit" name="consultar" class="btn btn-primary btn-xs">Ver Stats </button></td>
                </tr>
            </table>

            <hr>

            <input type="text" name="players" placeholder="Buscar jugador" onkeyup="predictionsPlayer()" size="15" class="form-control">

            <input type="text" name="team" placeholder="Buscar datos del equipo" onkeyup="predictionsTeam()" size="20" class="form-control">

            <hr>

            <div class="input-group">
                <span class="input-group-addon"> Universidades mejor puntuadas</span>
                <button type="button" class="btn btn-primary btn-sm" onclick="mejores_univeridades()">Mostrar</button>
            </div>

            <hr>
            <div class="input-group">
                <span class="input-group-addon"> Mayor cantidad de touchdowns anotados a</span>
                <select id="touchdown_select">
                    <?php
                        for($i=0; $i <pg_numrows($equipos); $i++){
                            $row = pg_fetch_array($equipos, $i);
                            ?>
                            <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                    <?php
                        }
                    ?>
                </select>
                <button type="button" class="btn btn-primary btn-sm" onclick="mostTouchdowns()">Mostrar</button>
            </div>

            <div id="resultados_busqueda" style="margin-left:120px;padding-left:5px;">

                <?php
                if(isset($_POST['order_players'])){
                    if(!$result || pg_numrows($result) <= 0){//no hay datos
                        ?> <span class="">No hay datos</span>
                    <?php
                    }else{//hay datos
                        ?>
                        <table>
                            <tr>
                                <?php for($i=1; $i <= $num_parametros; $i=$i+2){ ?>
                                <td>
                                    <?php echo array_keys($row)[$i]?>
                                </td>
                                <?php 
                                }
                                ?>
                            </tr>
                            <?php 
                                $numrows = pg_numrows($result);
                                for($i=0; $i < $numrows; $i++){
                                    $row = pg_fetch_array($result, $i);
                            ?>
                            <tr>
                                <?php 
                                        for($j=1; $j <= $num_parametros; $j=$j+2){ ?>
                                <td>
                                    <?php echo $row[array_keys($row)[$j]]?> </td>
                                <?php   } ?>
                            </tr>

                            <?php   } ?>

                        </table>
                        <?php 
                    }  
                }
                ?>
            </div>

            <br>


        </form>
    </body>

    <script>
        function llamar_otra_pagina_Equipo() {
            var texto = $('input[name="team"]').val();

            var process = function(response) {
                $('#resultados_busqueda').html(response);
            }

            getAPI("<?php echo $base_url; ?>/table_search_getter.php?team=" + texto, process);
        }

        function predictionsTeam() {
            if ($('input[name="team"]').val().length >= 1) {
                llamar_otra_pagina_Equipo();
            } else {
                $('#resultados_busqueda').html('');
            }
        }

        function llamar_otra_pagina_Player() {
            var texto = $('input[name="players"]').val();

            var process = function(response) {
                $('#resultados_busqueda').html(response);
            }

            getAPI("<?php echo $base_url; ?>/table_search_getter.php?player=" + texto, process);
        }

        function predictionsPlayer() {
            if ($('input[name="players"]').val().length >= 2) {
                llamar_otra_pagina_Player();
            } else {
                $('#resultados_busqueda').html('');
            }
        }

        function mejores_univeridades() {
            var texto = "";

            var process = function(response) {
                $('#resultados_busqueda').html(response);
            }

            getAPI("<?php echo $base_url; ?>/table_search_getter.php?best_uni=" + texto, process);
        }

        function mostTouchdowns() {
            var texto = document.getElementById("touchdown_select").value;

            var process = function(response) {
                $('#resultados_busqueda').html(response);
            }

            getAPI("<?php echo $base_url; ?>/table_search_getter.php?touchdown=" + texto, process);
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