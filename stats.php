<?php
    
    include_once('dbconnect.php');

    
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
        <div align="center">
            <h2 class="display-4">Estadística</h2>
            <h5 class="display-4">Consultas</h5>
            <hr>
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
                        <select id="order_players" class="form-control">
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
                        <select id="order_by" class="form-control">
                            <option value="ASC">Ascendiente</option>
                            <option value="DESC">Descendiente</option>
                        </select>
                    </td>

                    <td>
                        <select id="show_limit" class="form-control">
                            <option value="LIMIT 10">10</option>
                            <option value="LIMIT 50">50</option>
                            <option value="LIMIT 100">100</option>
                            <option value="">Todo</option>
                        </select>
                    </td>

                    <td><button type="button" id="consultar" class="btn btn-primary btn-sm">Ver Stats </button></td>
                </tr>
            </table>

            <hr>
            <div class="row">
                <div class="col-xs-5">
                    <input type="text" id="players" placeholder="Buscar jugador" size="15" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-5">
                    <input type="text" id="team" placeholder="Buscar datos del equipo" size="20" class="form-control">
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <div class="input-group">
                        <span class="input-group-addon"> Universidades mejor puntuadas</span>
                        <span class="input-group-btn"><button type="button" class="btn btn-primary btn-sm" id="uni_mejor_puntuadas" onclick="mejores_univeridades()">Mostrar</button></span>
                    </div>
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col-xs-10">
                    <div class="input-group">
                        <span class="input-group-addon"> Equipo que más touchdowns le anotó a</span>
                        <span class="input-group-addon"><select id="touchdown_select" class="form-control">
                            <?php
                            for($i=0; $i <pg_numrows($equipos); $i++){
                                $row = pg_fetch_array($equipos, $i);
                                ?>
                                <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                            <?php
                                }
                            ?>
                        </select></span>
                        <span class="input-group-btn"><button type="button" class="btn btn-primary btn-lg" id="touchdown_button">Mostrar</button></span>
                    </div>
                </div>
            </div>

            <div id="resultados_busqueda" style="margin-left:120px;padding-left:5px;">


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

        $(document).ready(function() {
            $("#players").keyup(function() {
                var valor_enviar = $("#players").val();
                $.post("table_search_getter.php", {
                        player: valor_enviar
                    },
                    function(data, status) {
                        $('#resultados_busqueda').html(data);
                    });
            });
        });

        $(document).ready(function() {
            $("#team").keyup(function() {
                var valor_enviar = $("#team").val();
                $.post("table_search_getter.php", {
                        team: valor_enviar
                    },
                    function(data, status) {
                        $('#resultados_busqueda').html(data);
                    });
            });
        });

        $(document).ready(function() {
            $("#touchdown_button").click(function() {
                var valor_enviar = document.getElementById("touchdown_select").value;
                $.post("table_search_getter.php", {
                        touchdown: valor_enviar
                    },
                    function(data, status) {
                        $('#resultados_busqueda').html(data);
                    });
            });
        });

        $(document).ready(function() {
            $("#uni_mejor_puntuadas").click(function() {
                var valor_enviar = "";
                $.post("table_search_getter.php", {
                        best_uni: valor_enviar
                    },
                    function(data, status) {
                        $('#resultados_busqueda').html(data);
                    });
            });
        });

        $(document).ready(function() {
            $("#consultar").click(function() {
                var player = document.getElementById("order_players").value;
                var orden = document.getElementById(["order_by"]).value;
                var limit = document.getElementById(["show_limit"]).value;
                $.post("table_search_getter.php", {
                        order_players: player,
                        order_by: orden,
                        show: limit
                    },
                    function(data, status) {
                        $('#resultados_busqueda').html(data);
                    });
            });
        });

    </script>

    </html>
