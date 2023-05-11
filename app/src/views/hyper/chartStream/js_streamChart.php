<script>
async function resizeStreamChart() {

    let heightStreamChart = parseInt(heightWindow / 3) - adjustHeightCharts;
    removeStreamChart();
    d3.select('#streamHeartrate')
        .append('div')
        .attr("id", 'pedaladas_heartrate')
        .attr("class", 'mb-1')
        .style("height", heightStreamChart + 'px');

    d3.select('#streamSpeed')
        .append('div')
        .attr("id", 'pedaladas_speed')
        .attr("class", 'mb-1')
        .style("height", heightStreamChart + 'px');

    d3.select('#streamElevation')
        .append('div')
        .attr("id", 'pedaladas_elevation')
        .attr("class", 'mb-1')
        .style("height", heightStreamChart + 'px');

    let widthStreamMetrics = $('#pedaladas_heartrate').width();
    d3.select('#streamMetrics')
        .style("width", widthStreamMetrics + "px")
        .style("display", "block");
}

async function removeStreamChart() {

    d3.select('#pedaladas_heartrate').remove();
    d3.select('#pedaladas_speed').remove();
    d3.select('#pedaladas_elevation').remove();

}

async function create_StreamChart(stream, title, scale, legends, color, data, max, min) {

    var chartDom = document.getElementById(stream);
    var myChart = await echarts.init(chartDom, null, {
        renderer: 'svg'
    });
    var option;

    option = {
        backgroundColor: 'rgb(255, 255, 255)',
        animation: true,
        color: color,
        title: {
            show: true,
            text: `${title}: ${min} to ${max} (${scale})`,
            textStyle: {
                fontSize: 12
            }
        },
        tooltip: {
            trigger: 'axis',
            triggerOn: "none",
            alwaysShowContent: true,
            enterable: true,
            axisPointer: {
                type: 'cross',
                lineStyle: {
                    width: 2,
                    type: 'solid'
                }
            },
            position: function(pos, params, dom, rect, size) {

                plotMarkerHotline(params, scale);
                // tooltip will be fixed on the right if mouse hovering on the left,
                // and on the left if hovering on the right.
                var obj = {
                    top: 60
                };
                obj[['left', 'right'][+(pos[0] < size.viewSize[0] / 2)]] = 5;
                return obj;
            },

            formatter: function(params) {
                let text = '';
                let linebreak = 1
                params.forEach(element => {
                    text +=
                        ` ${element.marker} 
                            ${element.value[0]} meters | 
                            ${element.value[1]} ${scale}&nbsp;&nbsp;`;

                    linebreak += 1;

                    if (linebreak > 2) {
                        text += '<br>';
                        linebreak = 1
                    }
                });
                return text;
            },
            textStyle: {
                fontSize: 10,
                fontWeight: 'bold'
            }
        },
        dataZoom: [{
            type: 'inside',
            zoomOnMouseWheel: true
        }],
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
            left: '50%',
            formatter: function(name) {
                return '';
            }
        },
        singleAxis: {
            type: 'value',
            max: 'dataMax',
            axisPointer: {
                snap: true,
                label: {
                    show: true,
                    formatter: function(params) {
                        return echarts.format.addCommas(params.value);
                    }
                },
                handle: {
                    show: true
                }
            },
            top: 25,
            bottom: 50,
            name: 'm',
            nameLocation: 'start',
            splitNumber: 5,
            splitLine: {
                show: true,
                lineStyle: {
                    type: 'solid',
                    opacity: 1
                }
            }
        },
        series: [{
            type: 'themeRiver',
            data: data,
            boundaryGap: ['1%', '1%'],
            label: {
                show: false
            },
            emphasis: {
                focus: 'self',
                label: {
                    show: false
                },
                labelLine: {
                    show: false
                }
            }
        }]
    };

    option && await myChart.setOption(option);

    return myChart;
}

async function mountLegendStreamChart(pedaladas) {

    let legend = [];
    pedaladas.forEach(element => {
        legend.push(element.id);
    });

    return legend;
}

async function mountColor(pedaladas) {

    let colorStream = [];
    pedaladas.forEach(element => {
        colorStream.push(element.color_selected);
    });
    return colorStream;
}

async function mountDataStream(pedaladas, type) {

    let data = [];
    let max = [];
    let min = [];

    if (type == 'heartrate') {

        pedaladas.forEach(element => {
            data = data.concat(element.heartrate_stream);

            max.push(element.heartrate_stream_max);
            min.push(element.heartrate_stream_min);
        });
    }

    if (type == 'elevation') {
        pedaladas.forEach(element => {
            data = data.concat(element.elevation_stream);

            max.push(element.elevation_stream_max);
            min.push(element.elevation_stream_min);

        });
    }

    if (type == 'speed') {

        pedaladas.forEach(element => {
            data = data.concat(element.speed_stream);

            max.push(element.speed_stream_max);
            min.push(element.speed_stream_min);

        });
    }

    return {
        'max': Math.max(...max),
        'min': Math.min(...min),
        'data': data
    };
}


async function updateStreamChart() {

    console.log("Update StreamChart ...");
    await resizeStreamChart();

    let legends = await mountLegendStreamChart(pedaladas_barChart);
    let colorStream = await mountColor(pedaladas_barChart);

    let heartData = await mountDataStream(pedaladas_barChart, 'heartrate');
    let speedData = await mountDataStream(pedaladas_barChart, 'speed');
    let elevationData = await mountDataStream(pedaladas_barChart, 'elevation');

    let streamHeartRate = await create_StreamChart(
        'pedaladas_heartrate',
        'Frequência Cardíaca',
        'bpm',
        legends,
        colorStream,
        heartData.data,
        heartData.max,
        heartData.min
    );

    let streamSpeed = await create_StreamChart(
        'pedaladas_speed',
        'Velocidade',
        'KM/H',
        legends,
        colorStream,
        speedData.data,
        speedData.max,
        speedData.min
    );

    let streamElevation = await create_ElevationStream(
        'pedaladas_elevation',
        'Elevação',
        'meters',
        legends,
        colorStream,
        elevationData.data,
        elevationData.max,
        elevationData.min
    );

    return [streamHeartRate, streamSpeed, streamElevation];
}
</script>