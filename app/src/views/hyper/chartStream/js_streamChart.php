<script>
    async function resizeStreamChart() {

        let heightStreamChart = parseInt(heightWindow / 3) - adjustHeightCharts;
        removeStreamChart();
        d3.select('#streamHeartrate')
            .append('div')
            .attr("id", 'pedaladas_heartrate')
            .style("height", heightStreamChart + 'px');

        d3.select('#streamElevation')
            .append('div')
            .attr("id", 'pedaladas_elevation')
            .style("height", heightStreamChart + 'px');

        d3.select('#streamSpeed')
            .append('div')
            .attr("id", 'pedaladas_speed')
            .style("height", heightStreamChart + 'px');
    }

    async function removeStreamChart() {

        d3.select('#pedaladas_heartrate').remove();
        d3.select('#pedaladas_elevation').remove();
        d3.select('#pedaladas_speed').remove();

    }

    async function create_StreamChart(stream, title, scale, legends, color, data, max) {

        var chartDom = document.getElementById(stream);
        var myChart = await echarts.init(chartDom, null, {
            renderer: 'svg'
        });
        var option;

        option = {
            animation: true,
            legend: {
                data: legends,
                itemHeight: 12,
                itemWidth: 12,
                itemGap: 5,
                left: '40%',
                formatter: function(name) {
                    return '';
                }
            },
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
            dataZoom: [{
                type: 'slider', // this dataZoom component is dataZoom component of slider
                startValue: 0,
                top: 25,
                height: 25,
                minValueSpan: viewStream,
                labelFormatter: function(value, valueStr) {
                    return value.toFixed(2) + ` m`;
                }
            }],
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
                position: function(pt) {
                    return [pt[0] + 10, pt[1]];
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
            title: {
                show: true,
                text: `${title}: 0 to ${max} (${scale})`,
                textStyle: {
                    fontSize: 12
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
                top: 63,
                bottom: 40,
                name: 'm',
                nameLocation: 'start',
                splitLine: {
                    show: true,
                    lineStyle: {
                        type: 'solid',
                        opacity: 1
                    }
                }
            },
            color: color,
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
    }

    async function mountLegend(pedaladas) {

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

    async function normalizeData(pedalSort) {

        let tam = pedalSort[0].heartrate_stream.length;

        pedalSort.forEach(element => {
            if (element.heartrate_stream.length < tam) {
                tam = element.heartrate_stream.length
            }
        });

        for (let index = 0; index < pedalSort.length; index++) {
            pedalSort[index].heartrate_stream = pedalSort[index].heartrate_stream.slice(
                0,
                tam + 1
            );
        }

        tam = pedalSort[0].elevation_stream.length;
        pedalSort.forEach(element => {
            if (element.elevation_stream.length < tam) {
                tam = element.elevation_stream.length
            }
        });

        for (let index = 0; index < pedalSort.length; index++) {
            pedalSort[index].elevation_stream = pedalSort[index].elevation_stream.slice(
                0,
                tam + 1
            );
        }

        tam = pedalSort[0].speed_stream.length;
        pedalSort.forEach(element => {
            if (element.speed_stream.length < tam) {
                tam = element.speed_stream.length
            }
        });

        for (let index = 0; index < pedalSort.length; index++) {
            pedalSort[index].speed_stream = pedalSort[index].speed_stream.slice(
                0,
                tam + 1
            );
        }

        return pedalSort;
    }


    async function mountDataStream(pedaladas, type) {

        let data = [];
        let max = 0;
        let stream = [];

        if (type == 'heartrate') {

            pedaladas.forEach(element => {
                data = data.concat(element.heartrate_stream);

                if (element.heartrate_stream_max > max) {
                    max = element.heartrate_stream_max;
                }
            });
        }

        if (type == 'elevation') {
            pedaladas.forEach(element => {
                data = data.concat(element.elevation_stream);

                if (element.elevation_stream_max > max) {
                    max = element.elevation_stream_max;
                }

            });
        }

        if (type == 'speed') {

            pedaladas.forEach(element => {
                data = data.concat(element.speed_stream);

                if (element.speed_stream_max > max) {
                    max = element.speed_stream_max;
                }

            });
        }

        return {
            'max': parseInt(max),
            'data': data
        };
    }

    async function updateStreamChart() {

        console.log("Update StreamChart ...");
        await resizeStreamChart();
        //console.log(pedaladas_barChart);
        //let pedalStream = await normalizeData(pedaladas_barChart);

        let legends = await mountLegend(pedaladas_barChart);
        let colorStream = await mountColor(pedaladas_barChart);
        //pedaladas_barchart = await updatePedalada(pedaladas_barChart);

        let heartData = await mountDataStream(pedaladas_barChart, 'heartrate');
        let elevationData = await mountDataStream(pedaladas_barChart, 'elevation');
        let speedData = await mountDataStream(pedaladas_barChart, 'speed');

        //console.log(pedalSort);
        // console.log(heartData);
        // console.log(elevationData);
        // console.log(speedData);

        await create_StreamChart(
            'pedaladas_heartrate',
            'Heartrate',
            'bpm',
            legends,
            colorStream,
            heartData.data,
            heartData.max
        );

        await create_StreamChart(
            'pedaladas_elevation',
            'Elevation',
            'meters',
            legends,
            colorStream,
            elevationData.data,
            elevationData.max
        );

        await create_StreamChart(
            'pedaladas_speed',
            'Speed',
            'KM/H',
            legends,
            colorStream,
            speedData.data,
            speedData.max,
        );
    }
</script>