<script>
    async function minLengthAttribute(pedalada) {

        let min = [];
        min.push(pedalada.distance_history.length);
        min.push(pedalada.elevation_history.length);
        min.push(pedalada.heartrate_history.length);
        min.push(pedalada.speed_history.length);

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

    async function createStream(segment, attribute, pedal_id) {

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

    async function calculateSpeedIntensity(speeds, max) {

        let intensity = [];

        for (const item of speeds) {

            let number = parseFloat(
                math.format(
                    math.divide(item[1], max), {
                        notation: 'fixed',
                        precision: 1
                    }
                )
            );

            intensity.push((number < 0 ? number * (-1) : number));
        }

        return intensity;
    }

    async function calculateElevationIntensity(elevations, max, min) {

        let intensity = [];

        for (const item of elevations) {

            let number = parseFloat(
                math.format(
                    math.divide(item[1] - min, max - min), {
                        notation: 'fixed',
                        precision: 1
                    }
                )
            );

            intensity.push((number < 0 ? number * (-1) : number));
        }

        return intensity;
    }

    async function calculateHeartrateIntensity(heartrate, max, min) {

        let intensity = [];

        for (const item of heartrate) {

            let number = parseFloat(
                math.format(
                    math.divide(item[1] - min, max - min), {
                        notation: 'fixed',
                        precision: 1
                    }
                )
            );

            intensity.push((number < 0 ? number * (-1) : number));

        }

        return intensity;
    }

    async function calculateIntensity(speed, elevation, heartrate) {

        let intensity = [];

        for (let index = 0; index < speed.length; index++) {

            intensity.push(
                parseFloat(
                    math.format(
                        math.divide(speed[index] + elevation[index] + heartrate[index], 3), {
                            notation: 'fixed',
                            precision: 1
                        }
                    )
                )
            );

        }

        return intensity;
    }

    async function updatePedalada(pedaladas) {

        for (const element of pedaladas) {

            if (await checkStreamNull(element.id)) {

                let segments = await createSegment(element);

                let heartStream = await createStream(
                    segments[element.id],
                    element.heartrate_history,
                    element.id
                );

                let elevationStream = await createStream(
                    segments[element.id],
                    element.elevation_history,
                    element.id
                );

                let speedStream = await createStream(
                    segments[element.id],
                    element.speed_history,
                    element.id
                );

                element.map_point = heartStream.map_point;

                element.heartrate_stream = heartStream.stream;
                element.heartrate_stream_max = heartStream.max;
                element.heartrate_stream_min = heartStream.min;
                element.heartrate_intensity = await calculateHeartrateIntensity(
                    heartStream.stream, heartStream.max, heartStream.min
                );

                element.elevation_stream = elevationStream.stream;
                element.elevation_stream_max = elevationStream.max;
                element.elevation_stream_min = elevationStream.min;
                element.elevation_intensity = await calculateElevationIntensity(
                    elevationStream.stream, elevationStream.max, elevationStream.min
                );

                element.speed_stream = speedStream.stream;
                element.speed_stream_max = speedStream.max;
                element.speed_stream_min = speedStream.min;
                element.speed_intensity = await calculateSpeedIntensity(speedStream.stream, speedStream.max);
                element.intensity = await calculateIntensity(
                    element.speed_intensity, element.elevation_intensity, element.heartrate_intensity
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

    async function generateMultiVis() {

        console.group("Generate MultiVis");
        if (pedaladas_barChart.length > 0) {
            await updateButtonMultivis(pedaladas_barChart, false, true, false);
            pedaladas_barchart = await updatePedalada(pedaladas_barChart);
            await updateBarChart();
            await updateStreamChart();
            await updateHeatmapChart();
            await updateMapChart();
            let radarChartAVG = await updateRadarChartAVG();
            let radarChartSingle = await updateRadarChartSingle();
            await activeTriggerRadarCharts(radarChartAVG, radarChartSingle);
            await updateButtonMultivis(pedaladas_barChart, true, false, false);
        }
        console.groupEnd();
    }
</script>