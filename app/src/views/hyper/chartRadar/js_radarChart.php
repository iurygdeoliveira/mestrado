<script>
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

        // heartrate, elevation, distance, duration, speed
        return [
            pedalada.heartrate_AVG,
            pedalada.elevation_AVG,
            pedalada.temperature_AVG,
            pedalada.speed_AVG,
            await time_in_minutes(pedalada.duration)
        ];
    }

    async function mountValues(pedaladas) {

        let values = [];
        const promisesValues = pedaladas.map(async (pedalada, idx) => {
            values.push({
                'rider': pedalada.rider,
                'values': await formatValues(pedalada)
            });
        });

        await Promise.all(promisesValues);

        return values;

    }

    async function mountAverage(values) {

        let average = [];
        for (let count = 0; count < selected.length; count++) {

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

                let color = $('#' + selected[count]).attr('style').replace(";", "").replace("background-color: ", "");
                average.push({
                    'name': "Cyclist " + selected[count].replace(/[^0-9]/g, ''),
                    'value': [heartrate, elevation, temperature, speed, duration],
                    lineStyle: {
                        color: color
                    },
                    itemStyle: {
                        color: color
                    },
                });
            }
        }
        return average;

    }

    async function mountDataSetsRadarChart(pedaladas) {

        let values = await mountValues(pedaladas)
        return await mountAverage(values);
    }

    async function removeRadarChart() {

        d3.select('#pedaladas_radarChart').remove();
    }

    async function resizeRadarChart() {
        let heightRadarChart = parseInt(heightWindow / 2) - adjustHeightCharts;
        removeRadarChart();
        d3.select('#radarChart')
            .append('div')
            .attr("id", 'pedaladas_radarChart')
            .style("height", heightRadarChart + 'px');
    }

    async function defineMaxValues(dataset) {

        let maxHeartrate = [];
        let maxElevation = [];
        let maxTemperature = [];
        let maxSpeed = [];
        let maxDuration = [];
        let maxValues = [];
        dataset.forEach(element => {
            maxHeartrate.push(element.value[0]);
            maxElevation.push(element.value[1]);
            maxTemperature.push(element.value[2]);
            maxSpeed.push(element.value[3]);
            maxDuration.push(element.value[4]);
        });

        maxValues.push(
            Math.ceil(Math.max(...maxHeartrate.map(item => item))),
            Math.ceil(Math.max(...maxElevation.map(item => item))),
            Math.ceil(Math.max(...maxTemperature.map(item => item))),
            Math.ceil(Math.max(...maxSpeed.map(item => item))),
            Math.ceil(Math.max(...maxDuration.map(item => item)))
        );

        return maxValues;
    }

    async function create_RadarChart() {

        var chartDom = document.getElementById('pedaladas_radarChart');
        var myChart = await echarts.init(chartDom, null, {
            renderer: 'svg'
        });
        var option;

        let dataset = await mountDataSetsRadarChart(pedaladas_barChart);
        let maxValues = await defineMaxValues(dataset);

        // Montando legendas
        let legends = [];
        dataset.forEach(element => {
            legends.push(element.name);
        });

        option = {
            animation: true,
            toolbox: {
                show: true,
                feature: {
                    dataView: {
                        readOnly: false
                    },
                    saveAsImage: {}
                }
            },
            legend: {
                data: legends,
                itemHeight: 12,
                itemWidth: 12,
                itemGap: 5,
                formatter: function(name) {
                    return '';
                }
            },
            title: {
                show: true,
                text: `Average Indicators`,
                textStyle: {
                    fontSize: 12
                }
            },
            tooltip: {
                trigger: 'item',
                position: 'left'
            },
            radar: {
                nameGap: 7,
                center: ['50%', '52%'],
                indicator: [{
                        name: 'Avg Heartrate (BPM)',
                        max: maxValues[0]
                    },
                    {
                        name: 'Avg Elevation (M)',
                        max: maxValues[1]
                    },
                    {
                        name: 'Avg Temperature (ºC)',
                        max: maxValues[2]
                    },
                    {
                        name: 'Avg Speed (KM/H)',
                        max: maxValues[3]
                    },
                    {
                        name: 'Duration (Min)',
                        max: maxValues[4]
                    }
                ]
            },
            series: [{
                type: 'radar',
                emphasis: {
                    lineStyle: {
                        width: 4
                    },
                    areaStyle: {
                        opacity: 0.5
                    }
                },
                // Heartrate, Elevation, Temperature, Speed, Duration
                data: dataset
            }]
        };

        option && myChart.setOption(option);
    }

    async function updateRadarChart() {

        console.log("Update RadarChart ...");
        await resizeRadarChart();
        await create_RadarChart();
    }
</script>