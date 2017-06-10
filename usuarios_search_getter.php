<div id="res_busqueda">

    <?php
		include_once('dbconnect.php');
		$namesLike = $_GET['name'];

		$result = pg_exec($conn, "SELECT * FROM usuarios WHERE username ILIKE '$namesLike%' OR nombres ILIKE '$namesLike%' ");
        
				
		$res = array();
		
		if(!$result || pg_numrows($result) <= 0){//no hay datos
			
		}else{//hay datos
			$numrows = pg_numrows($result);
			for($i=0; $i < $numrows; $i++){
				$row = pg_fetch_array($result, $i);
				?>
        <a href="<?php echo $base_url; ?>/perfil_usuario.php?id=<?php echo $row['username']; ?>" title="<?php echo $row['username']; ?>">
            <?php echo $row['username']; ?>
        </a><br>
        <?php
				
			}
		}
	?>
</div>
