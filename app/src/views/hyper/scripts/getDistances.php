<script>
    async function storeDistance(rider) {

        if (!store.session.has(rider)) {
            let distances = await getDistances(rider);

            let maxDistance = (distances ? await getMaxDistance(distances) : null);

            store.session.set(rider, {
                distances: distances,
                maxDistance: maxDistance,
            });
            return;
        }

        if (store.session.get(rider).maxDistance <= 0) {
            // console.log('Erro na distância máxima do' + rider);
            return;
        }

        if (store.session.get(rider).maxDistance > 0) {
            // console.log('Distância máxima do ' + rider + ' presente no storage');
            return;
        }

        if (store.session.get(rider).distances.length < 0) {
            //console.log('Erro na captura de distâncias do ' + rider);
            return;
        }

        if (store.session.get(rider).distances.length > 0) {
            //console.log('Distâncias do ' + rider + ' presente no storage');
            return;
        }


    }

    async function getMaxDistance(distances) {

        console.log(distances);

        // var data = new FormData();
        // data.set('rider', rider);

        // return await axios.post(' //$this->e($url_maxDistance) ', data)
        //     .then(function(res) {

        //         if (res.data.status === true) {
        //             console.log(res.data.message);
        //             return res.data.response;
        //         }

        //         if (res.data.status === false) {
        //             console.log(res.data.message);
        //             return -1;
        //         }
        //     })
        //     .catch(function(error) {
        //         console.log("Erro");
        //         console.log(error);
        //         console.log(error.res.data);
        //         console.log(error.res.status);
        //         console.log(error.res.headers);
        //         return -1;
        //     });
    }

    async function getDistances(cyclist) {


        console.log("Cyclist " + cyclist.replace(/[^0-9]/g, '') + " without distances");
        let distances = await getDistancesGithub(cyclist);
        return distances;
        // var data = new FormData();
        // data.set('rider', rider);

        // return await axios.post(' $this->e($url_search_riders) ?>', data)
        // .then(function(res) {

        //         if (res.data.status === true) {
        //             console.log(res.data.message);
        //             return res.data.response;
        //         }

        //         if (res.data.status === false) {
        //             console.log(res.data.message);
        //             return -1;
        //         }

        //     })
        //     .catch(function(error) {
        //         console.log("Erro");
        //         console.log(error);
        //         console.log(error.res.data);
        //         console.log(error.res.status);
        //         console.log(error.res.headers);
        //         return -1;
        //     });
    }
</script>