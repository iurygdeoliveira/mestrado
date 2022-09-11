<script>
    // Obter distância com o passar do mouse
    $("input[type='checkbox']").hover(
        async function() {
            rider = $(this).attr("id");

            if (!store.session.has(rider)) {
                store.session.set(rider, {
                    maxDistance: await getMaxDistance(rider),
                    distances: await getDistances(rider),
                });
                console.log(store.session.get(rider));
                return;

            }

            if (store.session.get(rider).maxDistance <= 0) {
                console.log('Erro na distância máxima do' + rider);
                return;
            }

            if (store.session.get(rider).maxDistance > 0) {
                console.log('Distância máxima do ' + rider + ' presente no storage');
                return;
            }

            if (store.session.get(rider).distances.length < 0) {
                console.log('Erro na captura de distâncias do ' + rider);
                return;
            }

            if (store.session.get(rider).distances.length > 0) {
                console.log('Distâncias do ' + rider + ' presente no storage');
                return;
            }


        }
    );

    async function getMaxDistance(rider) {

        console.log('Ainda não existe distância máxima para o ' + rider);
        var data = new FormData();
        data.set('rider', rider);

        return await axios.post('<?= $this->e($url_maxDistance) ?>', data)
            .then(function(res) {

                if (res.data.status === true) {
                    console.log(res.data.message);
                    return res.data.response;
                }

                if (res.data.status === false) {
                    console.log(res.data.message);
                    return -1;
                }

            })
            .catch(function(error) {
                console.log("Erro");
                console.log(error);
                console.log(error.res.data);
                console.log(error.res.status);
                console.log(error.res.headers);
                return -1;
            });

    }

    async function getDistances(rider) {

        console.log('Ainda não existe a distância das pedaladas do ' + rider);
        var data = new FormData();
        data.set('rider', rider);

        return await axios.post('<?= $this->e($url_search_riders) ?>', data)
            .then(function(res) {

                if (res.data.status === true) {
                    console.log(res.data.message);
                    return res.data.response;
                }

                if (res.data.status === false) {
                    console.log(res.data.message);
                    return -1;
                }

            })
            .catch(function(error) {
                console.log("Erro");
                console.log(error);
                console.log(error.res.data);
                console.log(error.res.status);
                console.log(error.res.headers);
                return -1;
            });

    }

    // async function getDistances(rider) {
    //     if (store.session.has(rider)) {

    //         if (store.session.get(rider).maxDistance <= 0) {
    //             console.log('Erro na distância máxima do ' + rider);
    //             return -1;
    //         }

    //         if (store.session.get(rider).maxDistance > 0) {
    //             return store.session.get(rider).maxDistance;
    //         }
    //     } else {
    //         // Se distância máxima não existir, realiza a busca
    //         store.session.set(rider, {
    //             maxDistance: await getMaxDistance(rider)
    //         });
    //         return store.session.get(rider).maxDistance;
    //     }
    // }
</script>