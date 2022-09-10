<script>
    async function searchRiders() {

        updateButtonSearchRiders(selected, false, false, true, false, false);
        var data = new FormData();
        data.set('min', $('#range-min').text());
        data.set('max', $('#range-max').text());

        let index;
        for (index = 0; index < selected.length; index++) {

            data.set('rider', selected[index]);
            // console.log(selected[index]);
            // console.log($('#range-min').text());
            // console.log($('#range-max').text());

            let pedaladas = await axios.post('<?= $this->e($url_search_riders) ?>', data)
                .then(function(res) {

                    if (res.data.status === true) {
                        console.log(res.data.message);
                        //console.log(res.data.response);
                        updateButtonSearchRiders(selected, false, false, false, true, false);
                        return res.data.response;
                    }

                    if (res.data.status === false) {
                        console.log(res.data.message);
                        updateButtonSearchRiders(selected, false, false, false, false, true);
                        return -1;
                    }

                })
                .catch(function(error) {
                    console.log("Erro no servidor");
                    console.log(error);
                    updateButtonSearchRiders(selected, false, false, false, false, true);
                    return -1;
                });

            await createTableLens(pedaladas);

        }
    }

    function updateButtonSearchRiders(selected, search_riders, search_riders_update, search_riders_loading, search_riders_success, search_riders_danger) {

        // Atualizando botão de busca de pedaladas e slider ao 
        // modficar novamente os ciclistas selecionados
        let buttonSuccess = $('#search_rides_success').css("display");
        let buttonDanger = $('#search_rides_danger').css("display");
        //console.log(buttonSuccess, buttonDanger);
        if ((buttonSuccess == 'block') || (buttonDanger == 'block')) {
            $('#search_rides').hide();
            $('#search_rides_loading').hide();
            $('#search_rides_success').hide();
            $('#search_rides_danger').hide();
            $('#search_rides_update').show();
        }

        // Atualizando botão de busca de pedaladas e slider
        //console.log(selected.length)
        if (selected.length > 0) {
            document.getElementById('search_rides').disabled = false;
            document.getElementById('search_rides_update').disabled = false;
            $('#slider-range').show();
        } else {
            document.getElementById('search_rides').disabled = true;
            document.getElementById('search_rides_update').disabled = true;
            $('#slider-range').hide();

        }

        if (search_riders) {
            $('#search_rides_update').hide();
            $('#search_rides_loading').hide();
            $('#search_rides_success').hide();
            $('#search_rides_danger').hide();
            $('#search_rides').show();
        }

        if (search_riders_update) {
            $('#search_rides_loading').hide();
            $('#search_rides_success').hide();
            $('#search_rides_danger').hide();
            $('#search_rides').hide();
            $('#search_rides_update').show();
        }

        if (search_riders_loading) {
            $('#search_rides').hide();
            $('#search_rides_update').hide();
            $('#search_rides_success').hide();
            $('#search_rides_danger').hide();
            $('#search_rides_loading').show();
        }

        if (search_riders_success) {
            $('#search_rides').hide();
            $('#search_rides_update').hide();
            $('#search_rides_loading').hide();
            $('#search_rides_danger').hide();
            $('#search_rides_success').show();
        }

        if (search_riders_danger) {
            $('#search_rides').hide();
            $('#search_rides_update').hide();
            $('#search_rides_loading').hide();
            $('#search_rides_success').hide();
            $('#search_rides_danger').show();
        }

    }
</script>