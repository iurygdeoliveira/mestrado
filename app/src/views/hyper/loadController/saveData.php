<script>
    async function saveData(rider, dataset, count, url) {

        var data = new FormData();
        data.append('rider', rider);
        data.append('dataset', dataset);
        data.append('count', count);

        for (let index = 1; index <= count; index++) {

            data.append('atividade', index);
            await axios.post(url, data)
                .then(function(response) {

                    if (response.data.status === true) {
                        console.log(response.data.message);
                    } else {
                        console.log('erro ao salvar');
                    }

                })
                .catch(function(error) {
                    console.log("Erro");
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);


                });

        }
    }
</script>