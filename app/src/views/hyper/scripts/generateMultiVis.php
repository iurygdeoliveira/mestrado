<script>
    async function creatSegment(pedalada) {


        let segments = {};
        segments[pedalada.id] = [];

        let sum = 0;
        let meter = 0;

        for (let idx1 = 0, idx2 = 0; idx2 < pedalada.distance_history.length; idx2++) {

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
        let subarray = [];
        let size = viewStream;

        for (const iterator of segment) {

            subarray = await createSubarray(attribute, iterator);

            if (subarray.length == 0) {
                console.log(attribute);
                console.log(segment);
                console.log(subarray);
            }

            let avg = math.format(
                math.mean(subarray), {
                    notation: 'fixed',
                    precision: 2
                }
            );

            stream.push(
                [
                    size,
                    parseFloat(avg),
                    pedal_id
                ]
            );

            size += viewStream;

            if (avg > max) {
                max = parseFloat(avg);
            }

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