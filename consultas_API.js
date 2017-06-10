function llamar_otra_pagina_Perfil() {
    var texto = $('input[name="buscar_perfil"]').val();
    
    var process = function(response){
        $('#resultados_perfil').html(response);
    }
				
    getAPI("<?php echo $base_url; ?>/name_search_getter.php?name="+texto, process);
				
}
			
function predictionsPerfil(){
    if($('input[name="buscar_perfil"]').val().length >= 3){
        llamar_otra_pagina_Perfil();
    }else{
        $('#resultados_perfil').html('');
    }
}

function llamar_otra_pagina_Equipo() {
    var texto = $('input[name="buscar_equipo"]').val();
    
    var process = function(response){
        $('#resultados_equipos').html(response);
    }
				
    getAPI("<?php echo $base_url; ?>/team_search_getter.php?name="+texto, process);
				
}
			
function predictionsEquipo(){
    if($('input[name="buscador"]').val().length >= 3){
        llamar_otra_pagina_Equipo();
    }else{
        $('#resultados_jugador').html('');
    }
}
