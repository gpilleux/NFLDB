<div id="res_busqueda">

    <?php
		include_once('dbconnect.php');
		$namesLike = $_GET['name'];

		$result = pg_exec($conn, "SELECT *
							FROM players
							WHERE first_name ILIKE '$namesLike%'
							OR last_name ILIKE '$namesLike%' ");
				
		
		if(!$result || pg_numrows($result) <= 0){//no hay datos
			
		}else{//hay datos
			$numrows = pg_numrows($result);
            ?> <select name="select_perfil"> <?php 
			for($i=0; $i < $numrows; $i++){
				$row = pg_fetch_array($result, $i);
				?>
				<option value="<?php echo $row['first_name']." ".$row['last_name']; ?>"> <?php echo $row['first_name']." ".$row['last_name']; ?> </option>
				<?php
			}
            ?> </select> <button type="submit" value="ingresarJugador" class="btn btn-sm btn-success">Insertar a mis datos</button>
        <?php
		}
	?>
</div>
