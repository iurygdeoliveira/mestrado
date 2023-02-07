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

    async function checkStreamNull(pedalada) {

        let rider = pedalada.split("_");
        return await new Dexie(rider[0]).open()
            .then(async function(db) {

                let result = await db.table('pedaladas')
                    .where('pedal_id').equals(pedalada).toArray();

                if (result[0].heartrate_stream == null) {
                    console.log(`Ride stream ${pedalada} not calculated`);
                } else {
                    console.log(`Ride stream ${pedalada} is already calculated`);
                }

                return (result[0].heartrate_stream == null);
            });
    }

    async function modifyPedalada(pedalada) {

        let rider = pedalada.id.split("_");
        return await new Dexie(rider[0]).open()
            .then(async function(db) {

                await db.table('pedaladas').where('pedal_id').equals(pedalada.id).modify(result => {

                    result.elevation_stream = pedalada.elevation_stream;
                    result.elevation_intensity = pedalada.elevation_intensity;
                    result.elevation_stream_max = pedalada.elevation_stream_max;
                    result.elevation_stream_min = pedalada.elevation_stream_min;
                    result.heartrate_stream = pedalada.heartrate_stream;
                    result.heartrate_intensity = pedalada.heartrate_intensity;
                    result.heartrate_stream_max = pedalada.heartrate_stream_max;
                    result.heartrate_stream_min = pedalada.heartrate_stream_min;
                    result.speed_stream = pedalada.speed_stream;
                    result.speed_intensity = pedalada.speed_intensity;
                    result.speed_stream_max = pedalada.speed_stream_max;
                    result.speed_stream_min = pedalada.speed_stream_min;
                    result.intensity = pedalada.intensity;
                    result.intensity_normalized = pedalada.intensity_normalized;
                    result.map_point = pedalada.map_point;
                });
            });
    }

    async function elevationGain(elevation) {

        let data = [];
        data.push(0);

        for (let index = 1; index < elevation.length; index++) {

            let diff = parseFloat(
                math.format(
                    math.subtract(elevation[index], elevation[index - 1]), {
                        notation: 'fixed',
                        precision: 6
                    }
                )
            );

            data.push(diff);
        }

        return data;

    }

    async function elevationAVG(elevation) {

        let sum = math.sum(elevation);
        let avg = parseFloat((sum / elevation.length).toFixed(6))
        return avg
    }

    async function storePedalada(pedalada) {

        return await new Dexie(pedalada.rider).open()
            .then(async function(db) {

                return await getPedaladaDB(db, pedalada).then(async (result) => {
                    console.group("storePedalada");
                    console.log("Query return to indexedDB: ");
                    console.log(result);
                    if (!result) {
                        console.log(`Storing ride data ${pedalada.id}`);
                        console.groupEnd();
                        await getPedaladaGithub(pedalada.rider, pedalada.id).then(async (res) => {

                            let elevation_history = await elevationGain(
                                await convertStringData(res[1].elevation_google)
                            );
                            let elevation_AVG = await elevationAVG(elevation_history);

                            await db.table('pedaladas').add({
                                rider: pedalada.rider,
                                pedal_id: pedalada.id,
                                datetime: res[7].datetime,
                                country: res[7].country,
                                locality: res[7].locality,
                                elevation_AVG: elevation_AVG,
                                speed_AVG: await parseFloat(limitTamString(res[7].speed_avg, 10)),
                                temperature_AVG: await parseFloat(limitTamString(res[7].temperature_avg, 10)),
                                heartrate_AVG: await parseFloat(limitTamString(res[7].heartrate_avg, 10)),
                                duration: res[7].duration,
                                distance: await parseFloat(limitTamString(res[7].distance, 10)),
                                centroid: await convertCentroid(res[7].centroid),
                                pointInitial: await convertStringData(res[7].coordinateInicial),
                                pointFinal: await convertStringData(res[7].coordinateFinal),
                                points: await convertPoints(res[5].latitudes, res[6].longitudes),
                                map_point: null,
                                distance_history: await convertStringData(res[0].distance_history),
                                elevation_history: elevation_history,
                                elevation_intensity: null,
                                elevation_stream_max: null,
                                elevation_stream_min: null,
                                elevation_stream: null,
                                heartrate_history: await convertStringData(res[2].heartrate_history),
                                heartrate_intensity: null,
                                heartrate_stream_max: null,
                                heartrate_stream_min: null,
                                heartrate_stream: null,
                                speed_history: await convertStringData(res[3].speed_history),
                                speed_intensity: null,
                                speed_stream_max: null,
                                speed_stream_min: null,
                                speed_stream: null,
                                intensity: null,
                                intensity_normalized: null,
                                time_history: res[4].time_history.split('|')
                            });
                        });
                        return await getPedaladaDB(db, pedalada);
                    } else {
                        console.log(`${pedalada.id} ride data is already stored`);
                        console.groupEnd();
                        return result;
                    }
                });
            });
    }

    async function getRecord(pedalada_current) {

        return await new Dexie(pedalada_current.rider).open()
            .then(async function(db) {

                const result = await getPedaladaDB(db, pedalada_current).then(async (result) => {
                    console.log("Query return to indexedDB: ", result);
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