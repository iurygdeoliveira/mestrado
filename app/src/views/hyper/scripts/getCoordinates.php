<script>
    async function getCoordinates_in_DB(db, pedalada) {

        let result = await db.table('coordinates')
            .where('pedaladaID').equals(pedalada.id).toArray();

        if (result.length > 0) {
            return result;
        } else {
            return false;
        }
    }


    async function storeCoordinates(pedalada) {

        return await new Dexie(pedalada.rider).open()
            .then(async function(db) {

                return await getCoordinates_in_DB(db, pedalada).then(async (result) => {
                    console.group("IndexedDB");
                    console.log("Retorno da consulta ao indexedDB: ", result);
                    if (!result) {
                        console.log(`Armazenando coordenadas da pedalada ${pedalada.id}`);
                        console.groupEnd();
                        return await getCoordinates(pedalada.rider, pedalada.id).then(async (res) => {
                            return await db.table('coordinates').add({
                                pedaladaID: pedalada.id,
                                rider: pedalada.rider,
                                distance: pedalada.distance,
                                pointInitial: res.pointInitial,
                                pointFinal: res.pointFinal,
                                points: res.points,
                                points_percentage: res.points_percentage,
                                centroid: res.centroid,
                                elevation: res.elevation,
                                elevation_percentage: res.elevation_percentage,
                            });
                        })
                    } else {
                        console.log(`Coordenadas da pedalada ${pedalada.id} já estão armazenadas`);
                        console.groupEnd();
                        return result[0].id;
                    }
                });
            });
    }

    async function getCoordinates(rider, pedaladaID) {

        let id = pedaladaID.split("_");
        id = id[2];

        var data = new FormData();
        data.append('rider', rider);
        data.append('id', id);

        return await axios.post('<?= $this->e($url_getCoordinates) ?>', data)
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
</script>