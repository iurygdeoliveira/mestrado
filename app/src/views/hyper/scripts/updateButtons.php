<script>
    function updateButtonSearchRiders(selected, search_riders, search_riders_loading, search_riders_danger) {

        // Atualizando botão de busca de pedaladas e slider ao 
        // modficar novamente os ciclistas selecionados
        let buttonDanger = $('#search_rides_danger').css("display");
        //console.log(buttonSuccess, buttonDanger);
        if (buttonDanger == 'block') {
            $('#search_rides').hide();
            $('#search_rides_loading').hide();
            $('#search_rides_danger').hide();
            $('#search_rides_update').show();
        }

        // Atualizando botão de busca de pedaladas e slider
        //console.log(selected.length)
        if (selected.length > 0) {
            document.getElementById('search_rides').disabled = false;
            $('#slider-range').show();
        } else {
            document.getElementById('search_rides').disabled = true;
            $('#slider-range').hide();

        }

        if (search_riders) {
            $('#search_rides_loading').hide();
            $('#search_rides_danger').hide();
            $('#search_rides').show();
        }

        if (search_riders_loading) {
            $('#search_rides').hide();
            $('#search_rides_danger').hide();
            $('#search_rides_loading').show();
        }

        if (search_riders_danger) {
            $('#search_rides').hide();
            $('#search_rides_loading').hide();
            $('#search_rides_danger').show();
        }

    }
</script>