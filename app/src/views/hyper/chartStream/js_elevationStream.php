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
            data.push(parseFloat(element[1].toFixed(2)));
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

}

async function create_ElevationStream(stream, title, scale, legends, color, data, max, min) {

    let pedaladasGrouped = await ungroup(data, legends);
    let maxStream = await getMaxStream(pedaladasGrouped);
    let series = await mountSeries(pedaladasGrouped);

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
            text: `${title}: ${min.toFixed(2)} até ${max.toFixed(2)} (${scale})`,
            textStyle: {
                fontSize: 12
            }
        },
        tooltip: {
            trigger: 'axis',
            triggerOn: "none",
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
                plotMarkerHotline(params, scale);
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
                            ${element.axisValue} metros | 
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
            left: '50%',
            icon: 'roundRect',
            formatter: function(name) {
                return '';
            }
        },
        toolbox: {
            show: true,
            feature: {
                restore: {},
                saveAsImage: {}
            }
        },
        dataZoom: [{
            type: 'inside',
            zoomOnMouseWheel: true
        }],
        grid: {
            left: '2%',
            top: '10%',
            right: '5%',
            bottom: '10%',
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
            splitLine: {
                show: true,
                lineStyle: {
                    type: 'solid',
                    opacity: 1
                }
            },
            data: maxStream,
            splitNumber: 5,
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
            show: false,
            axisLine: {
                show: false,
                onZero: false
            },
            nameLocation: 'start'
        }],
        series: series
    };

    option && await myChart.setOption(option);

    return myChart;
}
</script>