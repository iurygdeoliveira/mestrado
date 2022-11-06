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

    async function convertTime(data) {

        let minute_history = [];
        minute_history.push(0);
        let position_history = [];
        position_history.push(0);

        let acumulator = 0;
        let diff = 0;
        let timeFinal;
        let timeInitial;

        for (let index = 0; index < data.length - 1; index++) {

            timeInitial = new Date('01/01/2000 ' + data[index]);
            timeFinal = new Date('01/01/2000 ' + data[index + 1]);

            diff = timeFinal.getTime() - timeInitial.getTime();

            if (diff < 0) {
                console.log(diff);
                console.log(timeFinal.getTime());
                console.log(timeInitial.getTime());
                console.log(index);
                throw new UserException("Invalid Convert time");
            } else {

                acumulator += (diff / 60000);
                if (acumulator >= 1) {
                    minute_history.push(minute_history.length);
                    position_history.push(index);
                    acumulator = 0;
                }
            }


        }

        return {
            'minute_history': minute_history,
            'position': position_history
        };
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

    async function createStream(time, attribute, pedal_id, avg) {


        let stream = [];
        let minute_history = time.minute_history;
        let position = time.position;
        let max = 0;

        for (let index = 0; index < minute_history.length; index++) {

            if (typeof attribute[position[index]] == 'number') {
                stream.push(
                    [
                        minute_history[index],
                        attribute[position[index]],
                        pedal_id
                    ]
                );

                if (attribute[position[index]] > max) {
                    max = attribute[position[index]];
                }

            } else {

                if (avg > max) {
                    max = avg;
                }
                console.log(attribute[position[index]]);
                stream.push([minute_history[index], avg, pedal_id]);
            }

        }

        return {
            'stream': stream,
            'max': max
        };
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
                        await getPedaladaGithub(pedalada.rider, pedalada.id).then(async (res) => {

                            let minute_history = await convertTime(res[4].time_history.split('|'));
                            console.log(minute_history);
                            let heartrate_history = await convertStringData(res[2].heartrate_history);
                            let avg_heartrate = await parseFloat(limitTamString(res[7].heartrate_avg, 10));
                            let heartrateStream = await createStream(
                                minute_history,
                                heartrate_history,
                                pedalada.id,
                                avg_heartrate);

                            console.log(heartrateStream);
                            await db.table('pedaladas').add({
                                rider: pedalada.rider,
                                pedal_id: pedalada.id,
                                datetime: res[7].datetime,
                                country: res[7].country,
                                locality: res[7].locality,
                                elevation_AVG: parseFloat(limitTamString(res[7].elevation_google, 10)),
                                speed_AVG: parseFloat(limitTamString(res[7].speed_avg, 10)),
                                temperature_AVG: parseFloat(limitTamString(res[7].temperature_avg, 10)),
                                heartrate_AVG: avg_heartrate,
                                duration: res[7].duration,
                                distance: parseFloat(limitTamString(res[7].distance, 10)),
                                centroid: await convertCentroid(res[7].centroid),
                                pointInitial: await convertStringData(res[7].coordinateInicial),
                                pointFinal: await convertStringData(res[7].coordinateFinal),
                                points: await convertPoints(res[5].latitudes, res[6].longitudes),
                                distance_history: await convertStringData(res[0].distance_history),
                                elevation_history: await convertStringData(res[1].elevation_google),
                                heartrate_history: heartrate_history,
                                heartrate_stream_max: heartrateStream.max,
                                heartrate_stream: heartrateStream.stream,
                                speed_history: await convertStringData(res[3].speed_history),
                                time_history: res[4].time_history.split('|'),
                                minute_history: minute_history
                            });
                        });
                        return await getPedaladaDB(db, pedalada);
                    } else {
                        console.log(`Dados da pedalada ${pedalada.id} já estão armazenadas`);
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