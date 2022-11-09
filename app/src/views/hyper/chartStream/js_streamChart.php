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
                type: 'inside', // this dataZoom component is dataZoom component of slider
                startValue: 0
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
                    return [pt[0], pt[1]];
                },

                formatter: function(params) {
                    let text = '';
                    let linebreak = 1
                    params.forEach(element => {
                        text +=
                            ` ${element.marker} 
                            ${element.value[0]} min | 
                            ${element.value[1]} bpm&nbsp;&nbsp;`;

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
                text: `${title}: 0 to ${max} (${scale})`
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
                top: 12,
                bottom: 40,
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
                label: {
                    show: false
                },
                emphasis: {
                    disabled: true
                }
            }]
        };

        option && await myChart.setOption(option);
    }

    async function sortStream() {

        let pedaladasGrouped = [];
        // Ordenando pedaladas
        for (let count = 0; count < selected.length; count++) {
            pedaladasGrouped.push(pedaladas_barChart.filter(item => item.rider == selected[count]));
        }

        let pedalSort = [];
        pedaladasGrouped.forEach(group => {
            group.forEach(pedal => {
                pedalSort.push(pedal);
            });
        });

        return pedalSort;
    }

    async function mountLegend(pedalSort) {

        let legend = [];
        let label;
        pedalSort.forEach(element => {
            label = element.id.split("_");
            legend.push('p' + label[2]);
        });

        return legend;
    }

    async function mountColor(pedalSort) {

        let colorStream = [];
        pedalSort.forEach(element => {
            colorStream.push(element.color_selected);
        });
        return colorStream;
    }

    async function mountDataStream(pedalSort, type) {

        let data = [];
        let max = 0;

        if (type == 'heartrate') {

            pedalSort.forEach(element => {
                data = data.concat(element.heartrate_stream);

                if (element.heartrate_stream_max > max) {
                    max = element.heartrate_stream_max;
                }

            });
        }

        if (type == 'elevation') {
            pedalSort.forEach(element => {
                data = data.concat(element.elevation_stream);

                if (element.elevation_stream_max > max) {
                    max = element.elevation_stream_max;
                }

            });
        }

        if (type == 'speed') {

            pedalSort.forEach(element => {
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

        console.group("StreamChart ...");
        console.log("Atualizando StreamChart ...");

        await resizeStreamChart();
        let pedalSort = await sortStream();

        console.log(pedalSort);

        let legends = await mountLegend(pedalSort);
        let colorStream = await mountColor(pedalSort);
        let heartData = await mountDataStream(pedalSort, 'heartrate');
        //let elevationData = await mountDataStream(pedalSort, 'elevation');
        //let speedData = await mountDataStream(pedalSort, 'speed');

        console.log(heartData);
        //console.log(elevationData);
        //console.log(speedData);

        await create_StreamChart(
            'pedaladas_heartrate',
            'Heartrate',
            'bpm',
            legends,
            colorStream,
            heartData.data,
            heartData.max
        );

        // await create_StreamChart(
        //     'pedaladas_elevation',
        //     'Elevation',
        //     'meters',
        //     legends,
        //     colorStream,
        //     elevationData.data,
        //     elevationData.max
        // );

        // await create_StreamChart(
        //     'pedaladas_speed',
        //     'Speed',
        //     'KM/H',
        //     legends,
        //     colorStream,
        //     speedData.data,
        //     speedData.max,
        // );
        console.groupEnd();
    }
</script>