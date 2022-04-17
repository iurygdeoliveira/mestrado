<script>
    async function getDataDiffVis(url, total) {

        $('#button_generate').hide();

        let index;
        for (index = 1; index <= parseInt(total); index++) {

            $('#button_loading').show();
            $('#diffvis_' + index).hide();

            var data = new FormData();
            data.append('rider', index);
            await axios.post(url, data)
                .then(function(res) {

                    if (res.data.status === true) {
                        console.log(res.data.message);

                        if (res.data.message === "Extração Concluída") {

                            let porcentagem = 100;
                            $('#progress_bar_' + rider).attr('style', "width: " + porcentagem + "%;");
                            $('#progress_bar_' + rider).attr('aria-valuenow', porcentagem);
                            $('#progress_bar_' + rider).text(porcentagem + "%");
                            index = parseInt(total) + 2; // Parar laço de repetição
                            $('#button_carregar_' + rider).hide();
                            $('#button_loading_' + rider).hide();
                            $('#button_success_' + rider).show();
                            $('#activity_extract_' + rider).text(total);
                        } else {

                            renderChart(index, res.data.response);
                        }
                    }

                    if (res.data.status === false) {
                        console.log(res.data.message);
                        console.log('erro ao buscar');
                        $('#button_generate').hide();
                        $('#button_loading').hide();
                        $('#button_success').hide();
                        $('#button_danger').show();
                        $('#error_extract').text(res.data.message);
                        index = parseInt(total) + 2; // Parar laço de repetição
                    }


                })
                .catch(function(error) {
                    console.log("Erro");
                    console.log(error);
                    $('#button_generate').hide();
                    $('#button_loading').hide();
                    $('#button_success').hide();
                    $('#button_danger').show();
                    $('#error_extract').text("Erro no catch");
                    index = parseInt(total) + 2; // Parar laço de repetição
                });


        }
        $('#button_loading').hide();

        if (index == parseInt(total) + 1) {

            $('#button_success').show();

        }
    }


    function renderChart(id, response) {

        $('#diffvis_' + id).show();
        $("#mapvis_" + id).css("height", (parseInt(response.length) / 100) * 200);

        // create data
        var data = [{
            children: response
        }];

        // create a chart and set the data
        chart = anychart.treeMap(data, "as-tree");

        // set the container id
        chart.container("mapvis_" + id);

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
            "Nós: {%nodes}\nAtividade: {%name}"
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