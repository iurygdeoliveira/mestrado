<script>
    async function ungroup(data, legends) {

        let pedaladasGrouped = [];
        // Ordenando pedaladas
        for (let count = 0; count < legends.length; count++) {
            pedaladasGrouped.push(data.filter(item => item[2] == legends[count]));
        }

        return pedaladasGrouped;
    }

    async function getMaxStream(pedaladasGrouped) {

        let max = [];
        let stream = [];

        pedaladasGrouped.forEach(element => {
            max.push(element.length);
        });

        let value = Math.max(...max);
        let index = max.indexOf(value);

        pedaladasGrouped[index].forEach(element => {

            stream.push(element[0]);

        });

        return stream;
    }

    async function mountSeries(pedaladasGrouped) {

        let series = [];
        pedaladasGrouped.forEach(group => {

            let data = [];

            group.forEach(element => {
                data.push(element[1]);
            });

            series.push({
                name: group[0][2],
                type: 'line',
                stack: 'Total',
                smooth: true,
                lineStyle: {
                    width: 0
                },
                showSymbol: false,
                areaStyle: {},
                emphasis: {
                    focus: 'series'
                },
                data: data
            })
        });

        return series;

        // [{
        //         name: 'Line 1',
        //         type: 'line',
        //         stack: 'Total',
        //         smooth: true,
        //         lineStyle: {
        //             width: 0
        //         },
        //         showSymbol: false,
        //         areaStyle: {},
        //         emphasis: {
        //             focus: 'series'
        //         },
        //         data: [0, 2, 11, -26, -9, 3, 2]
        //     },

        // }]
    }

    async function create_ElevationChart(stream, title, scale, legends, color, data, max) {

        let pedaladasGrouped = await ungroup(data, legends);
        let maxStream = await getMaxStream(pedaladasGrouped);
        let series = await mountSeries(pedaladasGrouped);

        console.log(series);
        var chartDom = document.getElementById(stream);
        var myChart = await echarts.init(chartDom, null, {
            renderer: 'svg'
        });
        var option;

        option = {
            animation: true,
            color: color,
            title: {
                show: true,
                text: `${title}: 0 to ${max} (${scale})`,
                textStyle: {
                    fontSize: 12
                }
            },
            tooltip: {
                trigger: 'axis',
                showContent: true,
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
                            ${element.axisValue} meters | 
                            ${element.value} ${scale}&nbsp;&nbsp;`;

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
            legend: {
                data: legends,
                itemHeight: 12,
                itemWidth: 12,
                itemGap: 5,
                left: '40%',
                icon: 'roundRect',
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
                xAxisIndex: 0,
                labelFormatter: function(value) {
                    return value.toFixed(2) + ` m`;
                }
            }],
            grid: {
                left: '2%',
                right: '5%',
                bottom: '9%',
                containLabel: true
            },
            xAxis: [{
                type: 'category',
                boundaryGap: false,
                position: 'bottom',
                offset: 0,
                axisLine: {
                    show: true,
                    onZero: false
                },
                data: maxStream,
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
                }
            }],
            yAxis: [{
                type: 'value',
                name: 'm',
                boundaryGap: ['1%', '1%'],
                max: 'dataMax',
                position: 'bottom',
                offset: 0,
                axisLine: {
                    show: true,
                    onZero: false
                },
                nameLocation: 'start'
            }],
            series: series
        };

        option && await myChart.setOption(option);
    }
</script>