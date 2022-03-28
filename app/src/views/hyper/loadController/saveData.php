<script>
    async function saveData(rider, dataset, count, url) {

        $('#button_carregar_' + rider).hide();
        var data = new FormData();
        data.append('rider', rider);
        data.append('dataset', dataset);
        data.append('count', count);
        data.append('atividade', 0);

        let index;
        for (index = 1; index <= parseInt(count); index++) {

            $('#button_loading_' + rider).show();
            data.set('atividade', index);
            await axios.post(url, data)
                .then(function(response) {

                    if (response.data.status === true) {
                        console.log(response.data.message);
                        let porcentagem = ((100 * index) / parseInt(count)).toFixed(2);
                        $('#progress_bar_' + rider).attr('style', "width: " + porcentagem + "%;");
                        $('#progress_bar_' + rider).attr('aria-valuenow', porcentagem);
                        $('#progress_bar_' + rider).text(porcentagem + "%");
                    }

                    if (response.data.status === false) {
                        console.log(response.data.message);
                        console.log('erro ao salvar');
                        $('#button_carregar_' + rider).hide();
                        $('#button_loading_' + rider).hide();
                        $('#button_success_' + rider).hide();
                        $('#button_danger_' + rider).show();
                        index = parseInt(count) + 2; // Parar laço de repetição
                    }

                })
                .catch(function(error) {
                    console.log("Erro");
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                    $('#button_carregar_' + rider).hide();
                    $('#button_loading_' + rider).hide();
                    $('#button_success_' + rider).hide();
                    $('#button_danger_' + rider).show();
                    index = parseInt(count) + 2; // Parar laço de receptição
                });

        }
        $('#button_loading_' + rider).hide();

        if (index == parseInt(count) + 1) {

            $('#button_success_' + rider).show();

        }
    }
</script>