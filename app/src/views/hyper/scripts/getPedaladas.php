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


    async function smooth(data, attribute) {



    }

    async function creatSegment(distance_history) {

        let sum = 0;
        let meter = 0;
        let position = [];
        position.push(0);
        let segment = [];
        let idx1 = 0;
        let idx2 = 0;

        for (; idx2 < distance_history.length; idx2++) {

            sum += distance_history[idx2];
            meter = sum * 1000;

            if (meter >= 48) {
                segment.push({
                    'distance': meter,
                    'idx1': idx1,
                    'idx2': idx2,
                });
                idx1 = idx2 + 1;
                sum = 0;
            }
        }

        return segment;

    }

    async function createStream(segment, attribute, pedal_id, avg) {

        let stream = [];
        let max = 0;
        let scale = 0;
        let subarray;

        console.log(segment);
        console.log(attribute);
        for (let index = 0; index < segment.length; index++, scale += 50) {

            if (segment[index].idx1 == segment[index].idx2) {

                subarray = segment[index].idx1;

            } else {

                subarray = attribute.slice(
                    segment[index].idx1,
                    segment[index].idx2 + 1
                );
            }

            console.log(subarray);
            let avg = math.mean(subarray);

            stream.push(
                [
                    scale,
                    avg,
                    pedal_id
                ]
            );

            if (avg > max) {
                max = avg;
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

                            let distance_history = await convertStringData(res[0].distance_history)
                            let segment = await creatSegment(distance_history);

                            let heartrate_history = await convertStringData(res[2].heartrate_history);
                            let avg_heartrate = await parseFloat(
                                limitTamString(res[7].heartrate_avg, 10)
                            );
                            let heartrateStream = await createStream(
                                segment,
                                heartrate_history,
                                pedalada.id,
                                avg_heartrate);

                            let elevation_history = await convertStringData(res[1].elevation_google);
                            let avg_elevation = await parseFloat(
                                parseFloat(limitTamString(res[7].elevation_google, 10))
                            );
                            // let elevationStream = await createStream(
                            //     minute_history,
                            //     elevation_history,
                            //     pedalada.id,
                            //     avg_elevation);

                            let speed_history = await convertStringData(res[3].speed_history);
                            let avg_speed = await parseFloat(
                                parseFloat(limitTamString(res[7].speed_avg, 10))
                            );
                            // let speedStream = await createStream(
                            //     minute_history,
                            //     speed_history,
                            //     pedalada.id,
                            //     avg_speed);

                            await db.table('pedaladas').add({
                                rider: pedalada.rider,
                                pedal_id: pedalada.id,
                                datetime: res[7].datetime,
                                country: res[7].country,
                                locality: res[7].locality,
                                elevation_AVG: avg_elevation,
                                speed_AVG: avg_speed,
                                temperature_AVG: parseFloat(limitTamString(res[7].temperature_avg, 10)),
                                heartrate_AVG: avg_heartrate,
                                duration: res[7].duration,
                                distance: parseFloat(limitTamString(res[7].distance, 10)),
                                centroid: await convertCentroid(res[7].centroid),
                                pointInitial: await convertStringData(res[7].coordinateInicial),
                                pointFinal: await convertStringData(res[7].coordinateFinal),
                                points: await convertPoints(res[5].latitudes, res[6].longitudes),
                                distance_history: distance_history,
                                elevation_history: elevation_history,
                                elevation_stream_max: null, //elevationStream.max,
                                elevation_stream: null, //elevationStream.stream,
                                heartrate_history: heartrate_history,
                                heartrate_stream_max: heartrateStream.max,
                                heartrate_stream: heartrateStream.stream,
                                speed_history: speed_history,
                                speed_stream_max: null, //speedStream.max,
                                speed_stream: null, //speedStream.stream,
                                time_history: res[4].time_history.split('|'),
                                minute_history: await convertTime(res[4].time_history.split('|'))
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