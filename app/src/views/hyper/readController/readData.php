<script>
    async function extractActivities(rider, dataset, total, url) {

        $('#button_carregar_' + rider).hide();
        $('#button_danger_' + rider).hide();
        var data = new FormData();
        data.append('rider', rider);
        data.append('total', total);
        data.append('dataset', dataset);
        data.append('atividade', 0);

        let index;
        for (index = 1; index <= parseInt(total); index++) {

            $('#button_loading_' + rider).show();
            data.set('atividade', index);
            await axios.post(url, data)
                .then(function(response) {

                    if (response.data.status === true) {
                        console.log(response.data.message);
                        let porcentagem = ((100 * index) / parseInt(total)).toFixed(2);
                        $('#progress_bar_' + rider).attr('style', "width: " + porcentagem + "%;");
                        $('#progress_bar_' + rider).attr('aria-valuenow', porcentagem);
                        $('#progress_bar_' + rider).text(porcentagem + "%");
                    }

                    if (response.data.status === false) {
                        console.log(response.data.message);
                        console.log('erro ao buscar');
                        $('#button_carregar_' + rider).hide();
                        $('#button_loading_' + rider).hide();
                        $('#button_success_' + rider).hide();
                        $('#button_danger_' + rider).show();
                        $('#progress_bar_' + rider).hide();
                        $('#rider_' + rider + '_error').text(response.data.message);
                        $('#rider_' + rider + '_error').show();
                        index = parseInt(total) + 2; // Parar laço de repetição
                    }

                })
                .catch(function(error) {
                    console.log("Erro");
                    console.log(error);
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                    $('#button_carregar_' + rider).hide();
                    $('#button_loading_' + rider).hide();
                    $('#button_success_' + rider).hide();
                    $('#button_danger_' + rider).show();
                    index = parseInt(total) + 2; // Parar laço de repetição
                });
        }
        $('#button_loading_' + rider).hide();

        if (index == parseInt(total) + 1) {

            $('#button_success_' + rider).show();

        }

    }
</script>