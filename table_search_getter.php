<div id="res_busqueda">
    <?php
    
    include_once('dbconnect.php');
    print_r($_POST);
    
    if(isset($_POST['player'])){
        $namesLike = $_POST['player'];
        $result = pg_exec($conn, "SELECT * FROM players
							 WHERE name ILIKE '%$namesLike%' LIMIT 20");
    }
    else if(isset($_POST['team'])){
        $namesLike = $_POST['team'];
        $result = pg_exec($conn, "select * from players where draft_team ilike '%$namesLike%' LIMIT 20");

    }else if(isset($_POST['best_uni'])){
        $result = pg_exec($conn, "select college as Universidad, round(avg(nflgrade)) as Rank from combine GROUP by college order by rank DESC LIMIT 10");
    }else if(isset($_POST['touchdown'])){
        $equipo = $_POST['touchdown'];
        $sql = "select W.name as Name, W.draft_team as Team, position as Position from players W,(
 select E.name as Equipo from shortnames E,(select P.OffenseTeam as Esquipo, sum(P.IsTouchdown) from pbp P,(select siglas from shortnames where name='$equipo') S where P.DefenseTeam=S.siglas Group by P.OffenseTeam order by sum desc limit 1) A where E.siglas=A.Esquipo) k where W.draft_team= k.Equipo and w.year_end=2013";
        $result = pg_exec($conn, $sql);
        
    }else if(isset($_POST['order_players'])){
        $order = $_POST['order_players'];
        $orderBy = $_POST['order_by'];
        $limit = $_POST['show']; 

        $result = pg_exec($conn, "SELECT * FROM players $order $orderBy $limit ");
    }
    if(pg_numrows($result) > 0){
        $row = pg_fetch_array($result, 0);
        $num_parametros = sizeof(array_keys($row));
    }

//print_r($num_parametros);

    if(!$result || pg_numrows($result) <= 0){//no hay datos
			?> <span class="">No hay datos</span>
        <?php
    }else{//hay datos
        ?>
            <table class="table table-striped table-hover">
                <tr>
                    <?php for($i=1; $i <= $num_parametros; $i=$i+2){ ?>
                    <td>
                        <?php echo array_keys($row)[$i]; ?>
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
                        <?php echo $row[array_keys($row)[$j]]; ?> </td>
                    <?php   
                        } 
                    ?>
                </tr>

                <?php   
                }
            ?>

            </table>
            <?php
    }
    ?>


</div>
