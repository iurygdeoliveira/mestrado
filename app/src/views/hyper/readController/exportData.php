<script>
    async function exportData(url, total) {

        $('#button_generate_csv').hide();
        $('#button_danger_csv').hide();
        $('#button_loading_csv').show();
        var data = new FormData();
        data.append('id', 0);

        let index;
        for (index = 1; index <= parseInt(total); index++) {

            data.set('id', index);
            await axios.post(url, data)
                .then(function(response) {

                    if (response.data.status === true) {
                        console.log(response.data.message);

                        if (response.data.message === "Extração Concluída") {

                            let porcentagem = 100;
                            $('#progress_bar_csv').attr('style', "width: " + porcentagem + "%;");
                            $('#progress_bar_csv').attr('aria-valuenow', porcentagem);
                            $('#progress_bar_csv').text(porcentagem + "%");
                            index = parseInt(total) + 2; // Parar laço de repetição
                            $('#button_carregar_csv').hide();
                            $('#button_loading_csv').hide();
                            $('#button_success_csv').show();
                            $('#activity_extract_csv').text(total);
                        } else {

                            let porcentagem = ((100 * index) / parseInt(total)).toFixed(2);
                            $('#progress_bar_csv').attr('style', "width: " + porcentagem + "%;");
                            $('#progress_bar_csv').attr('aria-valuenow', porcentagem);
                            $('#progress_bar_csv').text(porcentagem + "%");
                        }
                    }

                    if (response.data.status === false) {
                        console.log(response.data.message);
                        console.log('erro ao buscar');
                        $('#button_carregar_csv').hide();
                        $('#button_loading_csv').hide();
                        $('#button_success_csv').hide();
                        $('#button_danger_csv').show();
                        $('#error_extract').text(response.data.message);
                        index = parseInt(total) + 2; // Parar laço de repetição
                    }


                })
                .catch(function(error) {
                    console.log("Erro");
                    console.log(error);
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                    $('#button_carregar_csv').hide();
                    $('#button_loading_csv').hide();
                    $('#button_success_csv').hide();
                    $('#button_danger_csv').show();
                    index = parseInt(total) + 2; // Parar laço de repetição
                });


        }
        $('#button_loading_csv').hide();

        if (index == parseInt(total) + 1) {

            $('#button_success_csv').show();

        }

    }
</script>