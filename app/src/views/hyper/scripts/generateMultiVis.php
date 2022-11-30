<script>
    async function minLengthAttribute(pedalada) {

        let min = [];
        min.push(pedalada.distance_history.length);
        min.push(pedalada.elevation_history.length);
        min.push(pedalada.heartrate_history.length);
        min.push(pedalada.speed_history.length);

        return Math.min(...min);
    }

    async function creatSegment(pedalada) {

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

    async function createStream(segment, attribute, pedal_id, avg) {

        let stream = [];
        stream.push([0, 0, pedal_id]);
        let max = 0;
        let size = viewStream;

        for (const iterator of segment) {

            if (iterator.idx1 == iterator.idx2) {

                stream.push(
                    [
                        size,
                        parseFloat(attribute[iterator.idx1]),
                        pedal_id
                    ]
                );

                if (parseFloat(attribute[iterator.idx1]) > max) {
                    max = parseFloat(attribute[iterator.idx1]);
                }

            } else {

                let subarray = await createSubarray(attribute, iterator);

                if (subarray.length == 0) {
                    console.log(pedal_id);
                    console.table(iterator);
                    console.log(subarray);
                    console.log(attribute);
                }

                avg = parseFloat(
                    math.format(
                        math.mean(subarray), {
                            notation: 'fixed',
                            precision: 2
                        }
                    )
                );

                stream.push(
                    [
                        size,
                        parseFloat(avg),
                        pedal_id
                    ]
                );

                if (avg > max) {
                    max = avg;
                }
            }
            size += viewStream;
        }

        return {
            'stream': stream,
            'max': max
        };
    }

    async function updatePedalada(pedaladas) {

        for (const element of pedaladas) {

            if (await checkStreamNull(element.id)) {

                let segments = await creatSegment(element);

                let heartStream = await createStream(
                    segments[element.id],
                    element.heartrate_history,
                    element.id,
                    element.heartrate_AVG
                );

                let elevationStream = await createStream(
                    segments[element.id],
                    element.elevation_history,
                    element.id,
                    element.elevation_AVG
                );

                let speedStream = await createStream(
                    segments[element.id],
                    element.speed_history,
                    element.id,
                    element.speed_AVG
                );

                element.heartrate_stream = heartStream.stream;
                element.heartrate_stream_max = heartStream.max;
                element.elevation_stream = elevationStream.stream;
                element.elevation_stream_max = elevationStream.max;
                element.speed_stream = speedStream.stream;
                element.speed_stream_max = speedStream.max;
                await modifyPedalada(element);
            }
        }

        return pedaladas;
    }

    async function generateMultiVis() {

        console.group("Generate MultiVis");
        if (pedaladas_barChart.length > 0) {
            await updateButtonMultivis(pedaladas_barChart, false, true, false);
            pedaladas_barchart = await updatePedalada(pedaladas_barChart);
            await updateBarChart();
            await updateStreamChart();
            await updateMapChart();
            await updateRadarChart();
            await updateButtonMultivis(pedaladas_barChart, true, false, false);
        }
        console.groupEnd();
    }
</script>