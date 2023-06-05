<script>
    async function minLengthAttribute(pedalada) {

        let min = [];
        min.push(pedalada.distance_history.length);
        min.push(pedalada.elevation_history.length);
        min.push(pedalada.heartrate_history.length);
        min.push(pedalada.speed_history.length);

        if ((min[0] != min[1]) || (min[0] != min[2]) || (min[0] != min[3])) {
            console.log(pedalada);
        }

        return Math.min(...min);
    }

    async function createSegment(pedalada) {

        let segments = {};
        segments[pedalada.id] = [];

        let sum = 0;
        let meter = 0;

        let minAtribute = await minLengthAttribute(pedalada);

        for (let idx1 = 0, idx2 = 0; idx2 < minAtribute; idx2++) {

            sum += pedalada.distance_history[idx2];
            meter = parseFloat((sum * 1000).toFixed(2));

            if (meter >= segmentStream) {

                let segment = {
                    'distance': meter,
                    'idx1': idx1,
                    'idx2': idx2
                };
                segments[pedalada.id].push(segment);
                idx1 = idx2 + 1;
                sum = 0;
            }
        }

        return segments;

    }

    async function createSubarray(attribute, iterator) {

        return attribute.slice(
            iterator.idx1,
            iterator.idx2
        );

    }

    async function createStream(segment, attribute, pedal_id, name) {

        let stream = [];
        let pos = [];


        stream.push([0, 0, pedal_id]);

        pos.push({
            'axis': 0,
            'index': 0
        });
        let maxMin = [];
        let size = viewStream;

        for (const iterator of segment) {

            if (iterator.idx1 == iterator.idx2) {

                stream.push(
                    [
                        size,
                        parseFloat((attribute[iterator.idx1]).toFixed(6)),
                        pedal_id
                    ]
                );

                maxMin.push(parseFloat((attribute[iterator.idx1]).toFixed(6)));

            } else {

                let subarray = await createSubarray(attribute, iterator);

                let avg = parseFloat(
                    math.format(
                        math.mean(subarray), {
                            notation: 'fixed',
                            precision: 6
                        }
                    )
                );

                stream.push(
                    [
                        size,
                        avg,
                        pedal_id
                    ]
                );

                maxMin.push(avg);
            }
            pos.push({
                'axis': size,
                'index': iterator.idx1
            });
            size += viewStream;
        }

        return {
            'stream': stream,
            'max': Math.max(...maxMin),
            'min': Math.min(...maxMin),
            'map_point': pos
        };
    }

    async function calculateAttributeIntensity(attribute, max, min) {

        // attribute é o mesmo vetor utilizar no streamGraph
        // utilizar o valor que esta posição 1

        let intensity = [];

        for (const item of attribute) {

            let value = parseFloat(math.divide(item[1] - min, max - min));
            value = value * (1 - 0) + 0;
            value = math.format(
                value, {
                    notation: 'fixed',
                    precision: 2
                }
            );

            intensity.push(parseFloat(value));
        }

        intensity[0] = (intensity[0] < 0 ? intensity[0] * -1 : intensity[0]); // ajust

        return intensity;
    }


    async function calculateIntensityGlobal(speed, elevation, heartrate) {

        let intensity = [];

        for (let index = 0; index < speed.length; index++) {

            intensity.push(
                parseFloat(
                    math.format(
                        math.divide(speed[index] + elevation[index] + heartrate[index], 3), {
                            notation: 'fixed',
                            precision: 2
                        }
                    )
                )
            );

        }

        return intensity;
    }

    async function calculateIntensityNormalized(intensity, max, min) {

        let intensityNormalized = [];

        for (const item of intensity) {
            let value = parseFloat(math.divide(item - min, max - min));
            value = value * (1 - 0) + 0;
            value = math.format(
                value, {
                    notation: 'fixed',
                    precision: 2
                }
            );
            intensityNormalized.push(parseFloat(value));
        }

        return intensityNormalized;
    }

    async function adjustElevation(stream) {

        // Armazenar o valor do primeiro elemento para uso posterior
        let firstElementValue = stream[0][1];

        // Deslocar os valores para a esquerda
        for (let i = 0; i < stream.length - 1; i++) {
            stream[i][1] = stream[i + 1][1];
        }

        // Atribuir o valor do primeiro elemento ao último elemento
        stream[stream.length - 1][1] = firstElementValue;

        return stream;
    }

    async function identifyPattern(id, Elevation, Speed) {

        for (let i = 1; i < Elevation.length - 1; i++) {
            if (Elevation[i][1] > 20 && Speed[i][1] < Speed[i - 1][1] && Speed[i][1] < Speed[i + 1][1]) {
                console.log("Padrão detectado na pedalada: " + id);
                console.log("Padrão detectado na posição: " + i);
                console.log("Elevation: " + Elevation[i]);
                console.log("Speed: " + Speed[i]);
                console.log("Elevation + 1: " + Elevation[i + 1]);
                console.log("Speed + 1: " + Speed[i + 1]);
            }
        }

    }

    async function updatePedalada(pedaladas) {

        for (const element of pedaladas) {

            if (await checkStreamNull(element.id)) {

                let segments = await createSegment(element);

                let heartStream = await createStream(
                    segments[element.id],
                    element.heartrate_history,
                    element.id,
                    'heartrate'
                );

                let elevationStream = await createStream(
                    segments[element.id],
                    element.elevation_history,
                    element.id,
                    'elevation'
                );

                elevationStream.stream = await adjustElevation(elevationStream.stream);

                let speedStream = await createStream(
                    segments[element.id],
                    element.speed_history,
                    element.id,
                    'speed'
                );

                element.map_point = heartStream.map_point;

                element.heartrate_stream = heartStream.stream;
                element.heartrate_stream_max = heartStream.max;
                element.heartrate_stream_min = heartStream.min;
                element.heartrate_intensity = await calculateAttributeIntensity(
                    heartStream.stream, heartStream.max, heartStream.min
                );

                element.elevation_stream = elevationStream.stream;
                element.elevation_stream_max = elevationStream.max;
                element.elevation_stream_min = elevationStream.min;
                element.elevation_intensity = await calculateAttributeIntensity(
                    elevationStream.stream, elevationStream.max, elevationStream.min
                );

                element.speed_stream = speedStream.stream;
                element.speed_stream_max = speedStream.max;
                element.speed_stream_min = speedStream.min;
                element.speed_intensity = await calculateAttributeIntensity(
                    speedStream.stream, speedStream.max, speedStream.min
                );

                element.intensity = await calculateIntensityGlobal(
                    element.speed_intensity, element.elevation_intensity, element.heartrate_intensity
                );

                element.intensity_normalized = await calculateIntensityNormalized(
                    element.intensity, Math.max(...element.intensity), Math.min(...element.intensity)
                );

                await modifyPedalada(element);
            }
        }

        return pedaladas;
    }

    async function activeTriggerRadarCharts(avg, single) {

        avg.on('mouseover', async function(params) {
            colorizeData = params.name.replace("Cyclist ", 'rider');
            return await updateRadarChartSingle();
        });
    }

    async function activeTriggerDataZoom(stream, heatmap) {

        heatmap.on('datazoom', function(params) {
            stream[0].dispatchAction({
                type: 'dataZoom',
                start: params.start,
                end: params.end
            });
            stream[1].dispatchAction({
                type: 'dataZoom',
                start: params.start,
                end: params.end
            });
            stream[2].dispatchAction({
                type: 'dataZoom',
                start: params.start,
                end: params.end
            });
        });
    }

    async function generateMultiVis() {

        console.group("Generate MultiVis");
        if (pedaladas_barChart.length > 0) {
            await updateButtonMultivis(pedaladas_barChart, false, true, false);
            pedaladas_barchart = await updatePedalada(pedaladas_barChart);
            await updateBarChart();
            let stream = await updateStreamChart();
            let heatmap = await updateHeatmapChart();
            await updateMapChart(pedaladas_barChart);
            let radarChartAVG = await updateRadarChartAVG();
            let radarChartSingle = await updateRadarChartSingle();
            await activeTriggerRadarCharts(radarChartAVG, radarChartSingle);
            await activeTriggerDataZoom(stream, heatmap);
            await updateButtonMultivis(pedaladas_barChart, true, false, false);
        }
        console.groupEnd();
    }
</script>