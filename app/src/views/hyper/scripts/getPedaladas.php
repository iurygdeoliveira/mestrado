<script>
    function limitTamString(value, tam) {

        if (value.length > tam) {
            return value.substring(0, 9);
        }
        return value;
    }

    async function convertCentroid(centroid) {

        let aux = centroid.split('|');

        aux[0] = parseFloat(limitTamString(aux[0], 10));
        aux[1] = parseFloat(limitTamString(aux[1], 10));
        return aux;

    }

    async function convertStringData(data) {

        let aux1 = data.split('|');
        let aux2 = [];

        aux1.forEach(element => {
            aux2.push(parseFloat(limitTamString(element, 10)))
        });

        return aux2;
    }

    async function convertPoints(latitudes, longitudes) {

        let aux = [];
        latitudes = await convertStringData(latitudes);
        longitudes = await convertStringData(longitudes);
        if (latitudes.length == longitudes.length) {

            for (let index = 0; index < latitudes.length; index++) {
                aux.push(
                    [latitudes[index], longitudes[index]]
                );
            }
            return aux;
        } else {
            return null
        }

    }

    async function getPedaladaDB(db, pedalada) {

        let result = await db.table('pedaladas')
            .where('pedal_id').equals(pedalada.id).toArray();

        if (result.length > 0) {
            return result;
        } else {
            return false;
        }
    }

    async function storePedalada(pedalada) {

        return await new Dexie(pedalada.rider).open()
            .then(async function(db) {

                return await getPedaladaDB(db, pedalada).then(async (result) => {
                    console.group("storePedalada");
                    console.log("Retorno da consulta ao indexedDB: ", result);
                    if (!result) {
                        console.log(`Armazenando dados da pedalada ${pedalada.id}`);
                        console.groupEnd();
                        return await getPedaladaGithub(pedalada.rider, pedalada.id).then(async (res) => {

                            return await db.table('pedaladas').add({
                                rider: pedalada.rider,
                                pedal_id: pedalada.id,
                                datetime: res[7].datetime,
                                country: res[7].country,
                                locality: res[7].locality,
                                elevation_AVG: parseFloat(limitTamString(res[7].elevation_google, 10)),
                                speed_AVG: parseFloat(limitTamString(res[7].speed_avg, 10)),
                                temperature_AVG: parseFloat(limitTamString(res[7].temperature_avg, 10)),
                                heartrate_AVG: parseFloat(limitTamString(res[7].heartrate_avg, 10)),
                                duration: res[7].duration,
                                distance: parseFloat(limitTamString(res[7].distance, 10)),
                                centroid: await convertCentroid(res[7].centroid),
                                pointInitial: await convertStringData(res[7].coordinateInicial),
                                pointFinal: await convertStringData(res[7].coordinateFinal),
                                points: await convertPoints(res[5].latitudes, res[6].longitudes),
                                distance_history: await convertStringData(res[0].distance_history),
                                elevation_history: await convertStringData(res[1].elevation_google),
                                heartrate_history: await convertStringData(res[2].heartrate_history),
                                speed_history: await convertStringData(res[3].speed_history),
                                time_history: res[4].time_history.split('|'),
                            });
                        })
                    } else {
                        console.log(`Dados da pedalada ${pedalada.id} já estão armazenadas`);
                        console.groupEnd();
                        return result[0].id;
                    }
                });
            });
    }

    async function getRecord(pedalada_current) {

        return await new Dexie(pedalada_current.rider).open()
            .then(async function(db) {

                const result = await getPedaladaDB(db, pedalada_current).then(async (result) => {
                    console.log("Retorno da consulta ao indexedDB: ", result);
                    if (!result) {
                        console.log(`Pontos da Pedalada ${pedalada_current.id} não encontrados`);
                        return false;
                    } else {
                        return result[0];
                    }
                });
                return result;
            });

    }
</script>