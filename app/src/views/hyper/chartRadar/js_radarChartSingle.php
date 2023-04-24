<script>
    async function time_in_minutesSingle(time) {

        let minutes = time.split(':');
        minutes[0] = parseInt(minutes[0]);
        minutes[1] = parseInt(minutes[1]);
        minutes[2] = parseInt(minutes[2]);

        minutes[1] += parseFloat(minutes[0] * 60);
        minutes[1] += parseFloat(minutes[2] / 60);
        return parseFloat(minutes[1].toFixed(2));

    }

    async function formatValuesSingle(pedalada) {

        // heartrate, elevation, distance, duration, speed
        return [
            pedalada.heartrate_AVG,
            pedalada.elevation_AVG,
            pedalada.temperature_AVG,
            pedalada.speed_AVG,
            await time_in_minutesSingle(pedalada.duration)
        ];
    }

    async function prepareValuesSingle(pedaladas) {

        let values = [];
        const promisesValues = pedaladas.map(async (pedalada, idx) => {
            values.push({
                'rider': pedalada.id,
                'values': await formatValuesSingle(pedalada)
            });
        });

        await Promise.all(promisesValues);

        return values;

    }

    async function getColorRadarChart(ride) {

        let find = pedaladas_barChart.find(x => x.id === ride);
        return find.color_selected;

    }

    async function mountValuesSingle(rides) {

        let data = [];

        for (const item of rides) {

            let heartrate = parseFloat((item.values[0]).toFixed(2));
            let elevation = parseFloat((item.values[1]).toFixed(6));
            let temperature = parseFloat((item.values[2]).toFixed(2));
            let speed = parseFloat((item.values[3]).toFixed(2));
            let duration = parseFloat((item.values[4]).toFixed(2));

            let name = item.rider.replace('rider', 'C')
            name = name.replace('pedalada', 'ride');
            name = name.replace('_', ' - ');
            name = name.replace('_', ' ');

            let colorSelectedRadar = await getColorRadarChart(item.rider);

            data.push({
                'name': name,
                'value': [heartrate, elevation, temperature, speed, duration],
                lineStyle: {
                    color: colorSelectedRadar
                },
                itemStyle: {
                    color: colorSelectedRadar
                },
            });
        }

        return data;

    }

    async function separateRidesEmphasis() {

        // Extraindo as pedaladas de um ciclista específico
        let pedaladasEmphasis = pedaladas_barChart.filter(x =>
            x.id.includes(colorizeData)
        );

        return pedaladasEmphasis;

    }

    async function mountDataSetsRadarChartSingle(pedaladas) {

        let values;
        if (colorizeData) {
            let pedaladasRadarEmphasis = await separateRidesEmphasis(pedaladas)
            values = await prepareValuesSingle(pedaladasRadarEmphasis)
        } else {
            values = await prepareValuesSingle(pedaladas)
        }
        return await mountValuesSingle(values);
    }

    async function defineMaxMinValuesSingle(dataset) {

        let heartrate = [];
        let elevation = [];
        let temperature = [];
        let speed = [];
        let duration = [];
        let values = [];
        dataset.forEach(element => {
            heartrate.push(element.value[0]);
            elevation.push(element.value[1]);
            temperature.push(element.value[2]);
            speed.push(element.value[3]);
            duration.push(element.value[4]);
        });

        values.push(
            Math.ceil(Math.max(...heartrate.map(item => item))), // heartrate max
            Math.max(...elevation.map(item => item)), // elevation max
            Math.ceil(Math.max(...temperature.map(item => item))), // temperature max
            Math.ceil(Math.max(...speed.map(item => item))), /// speed max
            Math.ceil(Math.max(...duration.map(item => item))), // duration max
            Math.min(...elevation.map(item => item))
        );

        return values;
    }

    async function removeRadarChartSingle() {

        d3.select('#pedaladas_radarChartSingle').remove();
    }

    async function resizeRadarChartSingle() {
        let heightRadarChart = parseInt(heightWindow / 2) - adjustHeightCharts;
        removeRadarChartSingle();
        d3.select('#radarChartSingle')
            .append('div')
            .attr("id", 'pedaladas_radarChartSingle')
            .style("height", heightRadarChart + 'px');
    }

    async function create_RadarChartSingle() {

        var chartDom = document.getElementById('pedaladas_radarChartSingle');
        var myChart = await echarts.init(chartDom, null, {
            renderer: 'svg'
        });
        var option;

        let dataset = await mountDataSetsRadarChartSingle(pedaladas_barChart);
        let maxMinValues = await defineMaxMinValuesSingle(dataset);

        // Montando legendas
        let legends = [];
        dataset.forEach(element => {
            legends.push(element.name);
        });

        option = {
            backgroundColor: 'rgb(255, 255, 255)',
            animation: true,
            toolbox: {
                show: true,
                feature: {
                    dataView: {
                        readOnly: false
                    },
                    restore: {},
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
                text: `Average indicators for each ride`,
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
                        max: maxMinValues[0],
                        min: 30
                    },
                    {
                        name: 'Avg Elevation (M)',
                        max: maxMinValues[1],
                        min: maxMinValues[5]
                    },
                    {
                        name: 'Avg Temperature (ºC)',
                        max: maxMinValues[2],
                        min: 0
                    },
                    {
                        name: 'Avg Speed (KM/H)',
                        max: maxMinValues[3],
                        min: 0
                    },
                    {
                        name: 'Duration (Min)',
                        max: maxMinValues[4],
                        min: 0
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

        option && await myChart.setOption(option);

        myChart.getZr().on('click', async function(event) {
            if (event.target.__title === 'Restore') {
                colorizeData = false;
                await updateRadarChartSingle();
            };
        });

        return myChart;
    }

    async function updateRadarChartSingle() {

        console.log("Update RadarChartSingle ...");
        await resizeRadarChartSingle();
        return await create_RadarChartSingle();
    }
</script>