<script>
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

</script>
