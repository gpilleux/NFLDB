<?php

include_once('dbconnect.php');


$result = pg_exec($conn, "SELECT * FROM pbp LIMIT 10");
$row = pg_fetch_array($result, 0);
$num_parametros = sizeof(array_keys($row))/2 + 1;

//print_r($num_parametros);


?>
<!DOCTYPE html>
<html>
	<head>
		<title> Tabla Consultas </title>
        <meta charset="utf-8">
        <style>
            table, th, td {
            border: 1px solid black;
               }
        </style>
	</head>
    <body>
        <button type="button" name="paginaPrincipal" onclick="location.href='index.php'">Pagina Inicio </button>
        <table>
            <tr>
                <?php for($i=1; $i <= $num_parametros; $i=$i+2){ ?>
                    <td> <?php echo array_keys($row)[$i]?></td>
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
                            <td> <?php echo $row[array_keys($row)[$j]]?> </td>
                    <?php   } ?>
                </tr>
            
            <?php   } ?>
            
        </table>
    </body>