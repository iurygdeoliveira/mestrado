<script>
    async function generateMapViz(url) {
        colors2 = [
            "#a30000"
        ];
        (dataColors = $("#mapVis").data("colors")) &&
        (colors = dataColors.split(","));
        options = {
            chart: {
                height: 300,
                type: "heatmap"
            },
            dataLabels: {
                enabled: !1
            },
            plotOptions: {
                heatmap: {
                    colorScale: {
                        inverse: true
                    }
                }
            },
            colors: colors2,
            series: [{
                    name: "Atividade 1",
                    data: generateData(29, {
                        min: 0,
                        max: 18198
                    })
                },
                {
                    name: "Atividade 2",
                    data: generateData(29, {
                        min: 0,
                        max: 18198
                    })
                },
                {
                    name: "Atividade 3",
                    data: generateData(29, {
                        min: 0,
                        max: 18198
                    })
                },
                {
                    name: "Atividade 4",
                    data: generateData(29, {
                        min: 0,
                        max: 18198
                    })
                },
                {
                    name: "Atividade 5",
                    data: generateData(29, {
                        min: 0,
                        max: 18198
                    })
                },
                {
                    name: "Atividade 6",
                    data: generateData(29, {
                        min: 0,
                        max: 18198
                    })
                },
                {
                    name: "Atividade 7",
                    data: generateData(29, {
                        min: 0,
                        max: 18198
                    })
                },
                {
                    name: "Atividade 8",
                    data: generateData(29, {
                        min: 0,
                        max: 18198
                    })
                },
                {
                    name: "Atividade 9",
                    data: generateData(29, {
                        min: 0,
                        max: 18198
                    })
                },
            ],
            xaxis: {
                type: "category"
            },
            title: {
                text: 'MapVis - Tendências na quantidade de dados por atividade'
            },
        };


        function generateData(a, e) {
            for (var t = 0, r = []; t < a;) {
                var n = (t + 1).toString(),
                    o = Math.floor(Math.random() * (e.max - e.min + 1)) + e.min;
                r.push({
                    x: n,
                    y: o
                }), t++;
            }
            return r;
        }
        (chart = new ApexCharts(
            document.querySelector("#mapVis"),
            options
        )).render();
    }
</script>