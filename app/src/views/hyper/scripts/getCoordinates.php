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

    function limitTamString(value, tam) {

        if (value.length > tam) {
            return value.substring(0, 9);
        }
        return value;
    }

    function convertCentroid(centroid) {

        let aux1 = centroid.replace('[', '').replace(']', '');
        let aux2 = aux1.split(',');

        aux2[0] = parseFloat(limitTamString(aux2[0], 10));
        aux2[1] = parseFloat(limitTamString(aux2[1], 10));
        return aux2;

    }

    function convertElevation(elevation) {

        let aux1 = elevation.split('|');
        let aux2 = [];

        aux1.forEach(element => {
            aux2.push(parseFloat(limitTamString(element, 10)))
        });

        return aux2;
    }

    function convertHeartRate(heartrate) {
        return parseFloat(limitTamString(heartrate, 10));
    }

    function convertPoint(point) {

        let aux = point.split('|');

        aux[0] = parseFloat(limitTamString(aux[0], 10));
        aux[1] = parseFloat(limitTamString(aux[1], 10));
        return aux;
    }

    function convertPoints(points) {

        let aux1 = [];
        points.forEach(element => {
            let aux2 = element.split('|');
            aux2[0] = parseFloat(limitTamString(aux2[0], 10));
            aux2[1] = parseFloat(limitTamString(aux2[1], 10));
            aux1.push(aux2);
        });

        return aux1;

    }

    function convertSpeed(speed) {
        return parseFloat(limitTamString(speed, 10));
    }

    async function storeCoordinates(pedalada) {

        return await new Dexie(pedalada.rider).open()
            .then(async function(db) {

                return await getCoordinates_in_DB(db, pedalada).then(async (result) => {
                    console.group("storeCoordinates");
                    console.log("Retorno da consulta ao indexedDB: ", result);
                    if (!result) {
                        console.log(`Armazenando coordenadas da pedalada ${pedalada.id}`);
                        console.groupEnd();
                        return await getCoordinates(pedalada.rider, pedalada.id).then(async (res) => {
                            return await db.table('coordinates').add({
                                datetime: res.datetime,
                                pedaladaID: pedalada.id,
                                rider: pedalada.rider,
                                distance: pedalada.distance,
                                pointInitial: convertPoint(res.pointInitial),
                                pointFinal: convertPoint(res.pointFinal),
                                points: convertPoints(res.points),
                                points_percentage: res.points_percentage,
                                centroid: convertCentroid(res.centroid),
                                elevation: convertElevation(res.elevation),
                                elevation_percentage: res.elevation_percentage,
                                address: res.address,
                                time: res.time,
                                speed: convertSpeed(res.speed),
                                heartrate: convertHeartRate(res.heartrate),
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