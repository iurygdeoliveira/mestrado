<script>
    var chartDom = document.getElementById('main');
    var myChart = echarts.init(chartDom, null, {
        renderer: 'svg'
    });
    var option;

    option = {
        title: {
            show: true,
            text: 'Heartrate'
        },
        legend: {
            data: ['DQ', 'TY'],
            align: 'auto'
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross',
                lineStyle: {
                    color: 'rgba(0,0,0,0.2)',
                    width: 1
                }
            }
        },
        singleAxis: {
            top: 0,
            bottom: 400, // height chart
            splitLine: {
                show: true,
                lineStyle: {
                    type: 'dashed',
                    opacity: 0.2
                }
            }
        },
        color: ['rgb(211, 69, 90)', 'rgb(44, 136, 216)'],
        series: [{
            type: 'themeRiver',
            label: {
                show: false
            },
            selectedMode: 'series',
            data: [
                [0, 0, 'DQ'],
                [1, 1, 'DQ'],
                [1.5, 50, 'DQ'],
                [2, 10, 'DQ'],
                [0, 0, 'TY'],
                [1, 36, 'TY'],
                [2, 3, 'TY'],
                [4, 100, 'TY']
            ]
        }]
    };

    option && myChart.setOption(option);
</script>