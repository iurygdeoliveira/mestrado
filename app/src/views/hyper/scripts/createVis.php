<script>
    async function createVis() {
        //console.log(pedaladas);
        updateButtonCreateVis(pedaladas)

    }



    function updateButtonCreateVis(pedaladas) {

        // Atualizando botão de atualizar visualização ao 
        // modficar novamente os ciclistas selecionados
        let buttonCreateVis = $('#create_vis').css("display");
        console.log(buttonCreateVis);
        console.log(pedaladas);
        console.log(pedaladas.length);
        if ((buttonCreateVis == 'block')) {
            $('#create_vis').hide();
            $('#update_vis').show();
        }
        if ((buttonCreateVis == 'none') && (pedaladas.length > 0)) {
            $('#create_vis').show();
            $('#update_vis').hide();
        }

        // Atualizando botão de busca de pedaladas e slider
        //console.log(selected.length)
        // if (selected.length > 0) {
        //     document.getElementById('search_rides').disabled = false;
        //     document.getElementById('search_rides_update').disabled = false;
        // } else {
        //     document.getElementById('search_rides').disabled = true;
        //     document.getElementById('search_rides_update').disabled = true;

        // }

        // if (search_riders) {
        //     $('#search_rides_update').hide();
        //     $('#search_rides_loading').hide();
        //     $('#search_rides_success').hide();
        //     $('#search_rides_danger').hide();
        //     $('#search_rides').show();
        // }

        // if (search_riders_update) {
        //     $('#search_rides_loading').hide();
        //     $('#search_rides_success').hide();
        //     $('#search_rides_danger').hide();
        //     $('#search_rides').hide();
        //     $('#search_rides_update').show();
        // }

        // if (search_riders_loading) {
        //     $('#search_rides').hide();
        //     $('#search_rides_update').hide();
        //     $('#search_rides_success').hide();
        //     $('#search_rides_danger').hide();
        //     $('#search_rides_loading').show();
        // }

        // if (search_riders_success) {
        //     $('#search_rides').hide();
        //     $('#search_rides_update').hide();
        //     $('#search_rides_loading').hide();
        //     $('#search_rides_danger').hide();
        //     $('#search_rides_success').show();
        // }

        // if (search_riders_danger) {
        //     $('#search_rides').hide();
        //     $('#search_rides_update').hide();
        //     $('#search_rides_loading').hide();
        //     $('#search_rides_success').hide();
        //     $('#search_rides_danger').show();
        // }

    }
</script>