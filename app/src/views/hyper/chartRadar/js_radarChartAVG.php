<script>
async function time_in_minutesAVG(time) {

    let minutes = time.split(':');
    minutes[0] = parseInt(minutes[0]);
    minutes[1] = parseInt(minutes[1]);
    minutes[2] = parseInt(minutes[2]);

    minutes[1] += parseFloat(minutes[0] * 60);
    minutes[1] += parseFloat(minutes[2] / 60);
    return parseFloat(minutes[1].toFixed(2));

}

async function formatValuesAVG(pedalada) {

    // heartrate, elevation, distance, duration, speed
    return [
        pedalada.heartrate_AVG,
        pedalada.elevation_AVG,
        pedalada.temperature_AVG,
        pedalada.speed_AVG,
        await time_in_minutesAVG(pedalada.duration)
    ];
}

async function mountValuesAVG(pedaladas) {

    let values = [];
    const promisesValues = pedaladas.map(async (pedalada, idx) => {
        values.push({
            'rider': pedalada.rider,
            'values': await formatValuesAVG(pedalada)
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
            elevation = parseFloat((elevation / valuesRiders.length).toFixed(6));
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

async function mountDataSetsRadarChartAVG(pedaladas) {

    let values = await mountValuesAVG(pedaladas)
    return await mountAverage(values);
}

async function removeRadarChartAVG() {

    d3.select('#pedaladas_radarChartAVG').remove();
}

async function resizeRadarChartAVG() {
    let heightRadarChart = parseInt(heightWindow / 2) - adjustHeightCharts - 10;
    removeRadarChartAVG();
    d3.select('#radarChartAVG')
        .append('div')
        .attr("id", 'pedaladas_radarChartAVG')
        .attr("class", 'mb-1')
        .style("height", heightRadarChart + 'px');

    let widthStatsChart = $('#pedaladas_radarChartAVG').width();
    d3.select('#statsChart')
        .style("width", widthStatsChart + "px")
        .style("display", "block");
}

async function defineMaxValuesAVG(dataset) {

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
        Math.max(...maxElevation.map(item => item)),
        Math.ceil(Math.max(...maxTemperature.map(item => item))),
        Math.ceil(Math.max(...maxSpeed.map(item => item))),
        Math.ceil(Math.max(...maxDuration.map(item => item))),
        Math.min(...maxElevation.map(item => item))
    );

    return maxValues;
}

async function create_RadarChartAVG() {

    var chartDom = document.getElementById('pedaladas_radarChartAVG');
    var myChart = await echarts.init(chartDom, null, {
        renderer: 'svg'
    });
    var option;

    let dataset = await mountDataSetsRadarChartAVG(pedaladas_barChart);
    let maxValues = await defineMaxValuesAVG(dataset);

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
                saveAsImage: {}
            }
        },
        legend: {
            data: legends,
            itemHeight: 12,
            itemWidth: 12,
            itemGap: 5,
            top: '5%',
            formatter: function(name) {
                return '';
            }
        },
        title: {
            show: true,
            text: `Indicadores Médios dos Ciclistas`,
            textStyle: {
                fontSize: 12
            }
        },
        tooltip: {
            trigger: 'item',
            position: 'left'
        },
        radar: {
            axisName: {
                overflow: 'break'
            },
            nameGap: 7,
            center: ['50%', '52%'],
            indicator: [{
                    name: 'Freq. Cardíaca (BPM)',
                    max: maxValues[0],
                    color: 'rgb(50,50,50)'
                },
                {
                    name: 'Elev. (M)',
                    max: maxValues[1],
                    min: maxValues[5],
                    color: 'rgb(50,50,50)'
                },
                {
                    name: 'Temp. (ºC)',
                    max: maxValues[2],
                    color: 'rgb(50,50,50)'
                },
                {
                    name: 'Veloc. (KM/H)',
                    max: maxValues[3],
                    color: 'rgb(50,50,50)'
                },
                {
                    name: 'Dura. (Min)',
                    max: maxValues[4],
                    color: 'rgb(50,50,50)'
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

    return myChart;
}

async function updateRadarChartAVG() {

    console.log("Update RadarChart AVG ...");
    await resizeRadarChartAVG();
    return await create_RadarChartAVG();
}
</script>