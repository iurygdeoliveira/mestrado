<script>
    // async function time_in_hours(time) {

    //     let hours = time.split(':');
    //     hours[0] = parseInt(hours[0]);
    //     hours[1] = parseInt(hours[1]);
    //     hours[2] = parseInt(hours[2]);

    //     hours[0] += parseFloat(hours[1] / 60);
    //     hours[0] += parseFloat(hours[2] / 3600);
    //     return parseFloat(hours[0].toFixed(2));

    // }
    async function time_in_minutes(time) {

        let minutes = time.split(':');
        minutes[0] = parseInt(minutes[0]);
        minutes[1] = parseInt(minutes[1]);
        minutes[2] = parseInt(minutes[2]);

        minutes[1] += parseFloat(minutes[0] * 60);
        minutes[1] += parseFloat(minutes[2] / 60);
        return parseFloat(minutes[1].toFixed(2));

    }

    async function formatValues(pedalada) {

        //let result = await getRecord(pedalada);
        // heartrate, elevation, distance, duration, speed
        return [
            pedalada.heartrate_AVG,
            parseFloat((pedalada.elevation_AVG / 1000).toFixed(2)),
            pedalada.temperature_AVG,
            pedalada.speed_AVG,
            await time_in_minutes(pedalada.duration)
        ];
    }

    async function mountValues(pedaladas_barChart) {

        let values = [];
        const promisesValues = pedaladas_barChart.map(async (pedalada, idx) => {
            values.push({
                'rider': pedalada.rider,
                'values': await formatValues(pedalada)
            });
        });

        await Promise.all(promisesValues);
        console.log(values);
        return values;

    }

    async function mountAverage(values) {

        console.log("Mount Average ...");

        let average = [];
        for (let count = 0; count < selected.length; count++) {
            let color = $('#' + selected[count]).attr('style').replace(";", "").replace("background-color: ", "");

            let valuesRiders = values.filter(item => item.rider == selected[count]);

            if (valuesRiders.length > 0) {

                heartrate = 0;
                elevation = 0;
                temperature = 0;
                speed = 0;
                duration = 0;

                valuesRiders.forEach(element => {
                    heartrate += element.values[0];
                    elevation += element.values[1];
                    temperature += element.values[2];
                    speed += element.values[3];
                    duration += element.values[4];
                });

                heartrate = parseFloat((heartrate / valuesRiders.length).toFixed(2));
                elevation = parseFloat((elevation / valuesRiders.length).toFixed(2));
                temperature = parseFloat((temperature / valuesRiders.length).toFixed(2));
                speed = parseFloat((speed / valuesRiders.length).toFixed(2));
                duration = parseFloat((duration / valuesRiders.length).toFixed(2));

                average.push({
                    'label': "Cyclist " + selected[count].replace(/[^0-9]/g, ''),
                    'data': [heartrate, elevation, temperature, speed, duration],
                    'fill': false,
                    'borderColor': color,
                    'pointBackgroundColor': color,
                    'pointBorderColor': '#fff',
                    'pointHoverBackgroundColor': '#fff',
                    'pointHoverBorderColor': color
                });
            }
        }
        console.log(average);
        return average;
    }


    async function mountDataSetsRadarChart(pedaladas_barChart) {

        console.log("Montando dataset RadarChart ...");

        let values = await mountValues(pedaladas_barChart)
        return await mountAverage(values);
    }


    async function removeRadarChart() {

        d3.select('#pedaladas_radarChart').remove();
    }

    async function calculateHeightRadarChart() {

        return parseInt(heightWindow / 2);
    }

    async function createBoxRadarChart() {
        let heightRadarChart = await calculateHeightRadarChart();
        d3.select('#radarChart')
            .append('canvas')
            .attr("id", 'pedaladas_radarChart')
            .attr("height", heightRadarChart + 'px');

    }

    async function create_RadarChart() {

        const ctx = document.getElementById('pedaladas_radarChart');
        const data = {
            labels: [
                'Avg Heartrate (BPM)',
                'Avg Elevation (Meters)',
                'Avg Temperature (ºC)',
                'Avg Speed (KM/H)',
                'Duration (Minutes)',
            ],
            datasets: await mountDataSetsRadarChart(store.session.get('pedaladas_barChart'))
        };
        const myChart = new Chart(ctx, {
            type: 'radar',
            data,
            options: {
                scale: {
                    ticks: {
                        min: 0,
                        max: 5
                    }
                },
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                elements: {
                    line: {
                        borderWidth: 3
                    }
                }
            },
        });
    }

    async function updateRadarChart() {

        console.group("RadarChart ...");
        console.log("Atualizando RadarChart ...");

        await removeRadarChart();
        await createBoxRadarChart();
        //$('#pedaladas_barChart_card').show();
        await create_RadarChart();
        console.groupEnd();
        totalStorage(); // Monitorando Storage
    }
</script>