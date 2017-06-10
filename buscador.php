<!DOCTYPE html>
<html>
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script>
		function llamar_otra_pagina(){
			var texto = $('input[name="buscador"]').val();
			
			var process = function(response){
				$('#content').html(response);
			}
			
			getAPI("<?php echo $base_url; ?>/name_search_getter.php?name="+texto, process);
			
		}
	</script>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/getAPI.js"></script>
</head>
<body>
	<div id="content">
		
	</div>
	<input type="text" name="buscador">
	<button type="button" onClick="llamar_otra_pagina();">Colocar</button>
</body>
</html>