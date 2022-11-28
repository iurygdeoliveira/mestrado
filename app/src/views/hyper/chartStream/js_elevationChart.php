<script>
    option = {
        animation: true,
        color: ['#80FFA5', '#00DDFF', '#37A2FF', '#FF0087', '#FFBF00'],
        title: {
            text: 'Elevation'
        },
        tooltip: {
            trigger: 'axis',
            showContent: true,
            alwaysShowContent: true,
            enterable: true,
            position: function(pt) {
                return [pt[0] + 10, pt[1]];
            },
            axisPointer: {
                type: 'cross',
                label: {
                    backgroundColor: '#6a7985'
                }
            }
        },
        legend: {
            data: ['Line 1', 'Line 2', 'Line 3', 'Line 4', 'Line 5'],
            itemHeight: 12,
            itemWidth: 12,
            itemGap: 5,
            left: '40%',
            icon: 'rect',
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
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: [{
            type: 'category',
            boundaryGap: false,
            data: [0, 100, 200, 300, 400, 500, 600],
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
            nameLocation: 'start'
        }],
        series: [{
                name: 'Line 1',
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
                data: [0, 2, 11, -26, -9, 3, 2]
            },
            {
                name: 'Line 2',
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
                data: [0, 2, -11, 23, 2, -4, -3]
            },
            {
                name: 'Line 3',
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
                data: [0, 1, 2, -4, 9, -1, -2]
            },
            {
                name: 'Line 4',
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
                data: [0, -4, 2, -1, 1, -3, 5]
            },
            {
                name: 'Line 5',
                type: 'line',
                stack: 'Total',
                smooth: true,
                lineStyle: {
                    width: 0
                },
                showSymbol: false,
                label: {
                    show: true,
                    position: 'top'
                },
                areaStyle: {},
                emphasis: {
                    focus: 'series'
                },
                data: [0, -3, 1, -2, 2, 2, -1]
            }
        ]
    };
</script>