<div id="res_busqueda">

    <?php
		include_once('dbconnect.php');
		$namesLike = $_GET['name'];

		$result = pg_exec($conn, "SELECT *
							FROM shortnames
							WHERE siglas ILIKE '%$namesLike%'
							OR name ILIKE '%$namesLike%' ");
				
				
		$res = array();
		
		if(!$result || pg_numrows($result) <= 0){//no hay datos
            ?>
        <div> No se encontraron datos</div>
        <?php
		}else{//hay datos
			$numrows = pg_numrows($result);
            ?> <select name="select_equipo"> <?php
			for($i=0; $i < $numrows; $i++){
				$row = pg_fetch_array($result, $i);
				?>
				<option value="<?php echo $row['name']; ?>"> <?php echo $row['name']; ?> </option>
				<?php
			}
            ?> </select> <button type="submit" value="ingresarEquipo" class="btn btn-sm btn-success">Insertar a mis datos</button>
            <?php
		}
	?>
</div>
