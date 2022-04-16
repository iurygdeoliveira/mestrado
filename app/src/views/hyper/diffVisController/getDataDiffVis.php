<script>
    async function getDataDiffVis(url) {

        $('#button_generate').hide();
        $('#button_loading').show();
        $('#diffvis_1').show();
        // create data
        var data = [{
            children: [{
                    name: "Belgium",
                    value: 11443830,
                    capital: "Brussels"
                },
                {
                    name: "France",
                    value: 64938716,
                    capital: "Paris"
                },
                {
                    name: "Germany",
                    value: 80636124,
                    capital: "Berlin"
                },
                {
                    name: "Greece",
                    value: 10892931,
                    capital: "Athens"
                },
                {
                    name: "Italy",
                    value: 59797978,
                    capital: "Rome"
                },
                {
                    name: "Netherlands",
                    value: 17032845,
                    capital: "Amsterdam"
                },
                {
                    name: "Poland",
                    value: 38563573,
                    capital: "Warsaw"
                },
                {
                    name: "Romania",
                    value: 19237513,
                    capital: "Bucharest"
                },
                {
                    name: "Spain",
                    value: 46070146,
                    capital: "Madrid"
                },
                {
                    name: "United Kingdom",
                    value: 65511098,
                    capital: "London"
                }
            ]
        }];


        // create a chart and set the data
        chart = anychart.treeMap(data, "as-tree");

        // set the container id
        chart.container("mapVis");

        // set the sorting mode
        chart.sort("desc");

        // set the hover
        chart.selected().fill('lightseagreen', 1);

        // enable HTML for labels
        chart.labels().useHtml(true);

        // configure labels
        chart.labels()
            .format(
                "<span style='font-weight:bold; color:#000'>{%name}</span><br><span style='color:#000'>{%value}</span>"
            );

        // configure tooltips
        chart.tooltip().format(
            "population: {%value}\ncapital: {%capital}"
        );

        var customColorScale = anychart.scales.linearColor();
        customColorScale.colors(["#fff", "#6169d1"]);

        // set the color scale as the color scale of the chart
        chart.colorScale(customColorScale);

        // add a color range
        chart.colorRange().enabled(true);
        chart.colorRange().length("90%");

        // initiate drawing the chart
        chart.draw();
    }
</script>