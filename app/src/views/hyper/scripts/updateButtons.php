<script>
    function updateButtonSearchRiders(selected, search_riders, search_riders_loading, search_riders_danger) {


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

    async function updateButtonMultivis(pedaladas, generate, loading, update) {

        if (pedaladas.length > 0) {
            document.getElementById('buttonGenerateMultivis').disabled = false;
            document.getElementById('buttonUpdateMultivis').disabled = false;
        } else {
            document.getElementById('buttonGenerateMultivis').disabled = true;
            document.getElementById('buttonUpdateMultivis').disabled = true;
        }

        if (generate) {
            console.log("multivis");
            $('#buttonGenerateMultivis').show();
            $('#buttonUpdateMultivis').hide();
            $('#buttonLoadingMultivis').hide();
        }

        if (loading) {
            console.log("loading");
            $('#buttonGenerateMultivis').hide();
            $('#buttonUpdateMultivis').hide();
            $('#buttonLoadingMultivis').show();
        }

        if (update) {
            $('#buttonGenerateMultivis').hide();
            $('#buttonLoadingMultivis').hide();
            $('#buttonUpdateMultivis').show();
        }
    }
</script>