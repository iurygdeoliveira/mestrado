<script>
    function extractPedalada(arr, value) {

        return arr.filter(function(ele) {
            return ele.id === value.id;
        });

    }

    async function mount_pedalada_coordinate(pedalada) {

        let id = pedalada.id.split("_");
        id = id[2];
        return {
            'id': pedalada.id,
            'rider': pedalada.rider,
            'distance': pedalada.distance,
            'pointInitial': await getPointInitial(pedalada.rider, id),
            'bbox': await getBbox(pedalada.rider, id)
        };
    }

    async function storeCoordinates(pedalada) {

        let pedaladas_coordinates = store.session.get('pedaladas_coordinates');
        let extracted = extractPedalada(pedaladas_coordinates, pedalada);

        if (extracted.length == 0) {

            extracted = await mount_pedalada_coordinate(pedalada);
            store.session.add('pedaladas_coordinates', extracted);
        }
        console.log("Pedaladas Coordinates armazenadas:", store.session.get('pedaladas_coordinates'));
    }

    async function getPointInitial(rider, id) {

        var data = new FormData();
        data.append('rider', rider);
        data.append('id', id);

        return await axios.post('<?= $this->e($url_getPointInitial) ?>', data)
            .then(function(res) {

                if (res.data.status === true) {
                    //console.log(res.data.message);
                    return res.data.response;
                }

                if (res.data.status === false) {
                    //console.log(res.data.message);
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

    async function getBbox(rider, id) {

        var data = new FormData();
        data.append('rider', rider);
        data.append('id', id);

        return await axios.post('<?= $this->e($url_getBbox) ?>', data)
            .then(function(res) {

                if (res.data.status === true) {
                    //console.log(res.data.message);
                    return res.data.response;
                }

                if (res.data.status === false) {
                    // console.log(res.data.message);
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
</script>