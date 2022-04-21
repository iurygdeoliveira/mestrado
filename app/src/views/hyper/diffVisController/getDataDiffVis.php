<script>
    async function getDataDiffVis(url, total) {

        $('#button_generate_vis').hide();

        let index;
        for (index = 1; index <= parseInt(total); index++) {

            $('#button_loading_vis').show();
            $('#diffvis_' + index).hide();

            var data = new FormData();
            data.append('rider', index);
            await axios.post(url, data)
                .then(function(res) {

                    if (res.data.status === true) {
                        console.log(res.data.message);

                        if (res.data.message === "Extração Concluída") {

                            let porcentagem = 100;
                            $('#progress_bar_vis').attr('style', "width: " + porcentagem + "%;");
                            $('#progress_bar_vis').attr('aria-valuenow', porcentagem);
                            $('#progress_bar_vis').text(porcentagem + "%");
                            index = parseInt(total) + 2; // Parar laço de repetição
                            $('#button_generate_vis').hide();
                            $('#button_loading_vis').hide();
                            $('#button_success_vis').show();
                        } else {

                            renderChart(index, res.data.response);
                            let porcentagem = ((100 * index) / parseInt(total)).toFixed(2);
                            $('#progress_bar_vis').attr('style', "width: " + porcentagem + "%;");
                            $('#progress_bar_vis').attr('aria-valuenow', porcentagem);
                            $('#progress_bar_vis').text(porcentagem + "%");
                        }
                    }

                    if (res.data.status === false) {
                        console.log(res.data.message);
                        console.log('erro ao buscar');
                        $('#button_generate_vis').hide();
                        $('#button_loading_vis').hide();
                        $('#button_success_vis').hide();
                        $('#button_danger_vis').show();
                        $('#error_extract').text(res.data.message);
                        index = parseInt(total) + 2; // Parar laço de repetição
                    }


                })
                .catch(function(error) {
                    console.log("Erro");
                    console.log(error);
                    $('#button_generate_vis').hide();
                    $('#button_loading_vis').hide();
                    $('#button_success_vis').hide();
                    $('#button_danger_vis').show();
                    $('#error_extract').text(erro);
                    index = parseInt(total) + 2; // Parar laço de repetição
                });


        }
        $('#button_loading_vis').hide();

        if (index == parseInt(total) + 1) {

            $('#button_success_vis').show();

        }
    }


    function renderChart(id, response) {

        $('#diffvis_' + id).show();
        $("#diffchart_" + id).css("height", (parseInt(response.length) / 100) * 100);

        // create data
        var data = [{
            children: response
        }];

        // create a chart and set the data
        chart = anychart.treeMap(data, "as-tree");

        // set the container id
        chart.container("diffchart_" + id);

        // set the sorting mode
        chart.sort("desc");

        // set the hover
        chart.selected().fill('lightseagreen', 1);

        // enable HTML for labels
        chart.labels().useHtml(true);

        // configure labels
        chart.labels()
            .format(
                "<span>{%name}</span>"
            );

        // configure tooltips
        chart.tooltip().format(
            "Nós: {%nodes}\nValor: {%value}"
        );

        var customColorScale = anychart.scales.ordinalColor();
        customColorScale.ranges([{
                from: 18,
                to: 18
            },
            {
                from: 17,
                to: 17
            },
            {
                from: 16,
                to: 16
            },
            {
                from: 15,
                to: 15
            },
            {
                from: 14,
                to: 14
            },
            {
                from: 13,
                to: 13
            },
            {
                from: 12,
                to: 12
            },
            {
                from: 11,
                to: 11
            },
            {
                from: 10,
                to: 10
            },
            {
                from: 9,
                to: 9
            },
            {
                from: 47,
                to: 47,
            },
            {
                from: 46,
                to: 46,
            },
            {
                from: 44,
                to: 44,
            },
            {
                from: 43,
                to: 43,
            },
            {
                from: 42,
                to: 42,
            },
            {
                from: 41,
                to: 41,
            },
            {
                from: 40,
                to: 40,
            },
            {
                from: 39,
                to: 39,
            },
            {
                from: 38,
                to: 38,
            },
            {
                from: 37,
                to: 37,
            },
            {
                from: 36,
                to: 36,
            },
            {
                from: 35,
                to: 35,
            },
            {
                from: 34,
                to: 34,
            },
            {
                from: 33,
                to: 33,
            },
            {
                from: 32,
                to: 32,
            },
            {
                from: 31,
                to: 31,
            },
            {
                from: 28,
                to: 28,
            }
        ]);

        customColorScale.colors(["#AADAC1", "#CFE9C3", "#95EDED", "#80D3E3", "#83ACCB", "#B3B5C8", "#C8BAC3", "#FACCB7", "#FAE1A1", "#F3B0C3", "#9AF5B4", "#D4F0F0", "#AADAC1", "#CFE9C3", "#95EDED", "#80D3E3", "#83ACCB", "#B3B5C8", "#C8BAC3", "#FACCB7", "#FAE1A1", "#F3B0C3", "#9AF5B4", "#D4F0F0", "#AADAC1", "#CFE9C3", "#95EDED", "#80D3E3", "#83ACCB", "#B3B5C8", "#C8BAC3", "#FACCB7", "#FAE1A1", "#F3B0C3", "#9AF5B4", "#D4F0F0", ]);

        // set the color scale as the color scale of the chart
        chart.colorScale(customColorScale);

        // initiate drawing the chart
        chart.draw();

        sessionStorage.setItem("diffchart_" + id, chart.toJson(true));
    }
</script>