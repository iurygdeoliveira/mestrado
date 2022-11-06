<script>
    function resizeModalTableLens() {
        d3.select("#modalTableLens")
            .style('max-width', widthCharts + 'px')
            .style('left', widthSidebar + 'px');
    }

    function createLabels() {

        for (let count = 0; count < selected.length; count++) {
            let color = $('#' + selected[count]).attr('style').replace(";", "").replace("background-color: ", "");

            d3.select('#table_lens_label').append('div')
                .attr("id", "table_lens_label_" + count)
                .attr("class", "col mx-1 text-center fw-bold d-flex justify-content-center")
                .style('background-color', 'rgb(255,255,255)')
                .style('color', color)
                .text("Cyclist " + selected[count].replace(/[^0-9]/g, ''));
        }

    }

    function createBox() {

        for (let count = 0; count < selected.length; count++) {

            let color = $('#' + selected[count]).attr('style').replace(";", "").replace("background-color: ", "");

            d3.select('#table_lens_box').append('div')
                .attr("id", "table_lens_box_" + count)
                .attr("class", "col mx-1 p-1 justify-content-center")
                .attr("rider", selected[count])
                .style('background-color', 'rgb(255, 255, 255)')
                .style('border', '3px solid ' + color)
                .style('border-radius', '0.25rem');
        }

    }

    async function createSkeleton() {

        createLabels();
        createBox();
        resizeModalTableLens();
    }

    function removeTableLens() {

        d3.select('#table_lens_label_0').remove();
        d3.select('#table_lens_box_0').remove();
        d3.select('#table_lens_label_1').remove();
        d3.select('#table_lens_box_1').remove();
        d3.select('#table_lens_label_2').remove();
        d3.select('#table_lens_box_2').remove();
        d3.select('#table_lens_label_3').remove();
        d3.select('#table_lens_box_3').remove();
        d3.select('#table_lens_label_4').remove();
        d3.select('#table_lens_box_4').remove();

    }

    async function tableLens() {

        console.group("Ciclistas selecionados ...");
        console.log(selected);
        console.groupEnd();

        // Limpando conteudo dos svg's
        console.group("Table lens ...");
        console.log("Criando esqueleto do table lens ...");
        removeTableLens();
        await createSkeleton().then(async () => {

            console.log("Criando table lens ...");
            console.groupEnd();

            for (let count = 0; count < selected.length; count++) {

                let pedaladas = store.session.get(selected[count]).distances;
                let rider = selected[count];
                createTableLens(pedaladas, count, rider).then(() => {

                    if (has_pedaladas_barChart()) {
                        applyStateBarChar(d3.select("#table_lens_box_" + count).attr('rider'));
                    }
                });
            }
        });

        await enableTipsyTooltip("[line_clicked]", 'bottom-center');

        updateButtonSearchRiders(selected, true, false, false)

    }

    function applyHeightItem(line) {
        d3.select(line)
            .style('padding', padding_item)
            .style('margin-bottom', margin_item)
            .style('margin-top', margin_item);
    }

    function applyHeightOverview(line) {
        d3.select(line)
            .style('padding', padding_overview)
            .style('margin-bottom', margin_overview)
            .style('margin-top', margin_overview);
    }

    function adjustHeightLine(line) {

        let stateLine = d3.select(line).attr('line_clicked');
        if (stateLine == 'true') {
            applyHeightItem(line);
        } else {
            switch (switchToggle) {
                case 'item':
                    applyHeightItem(line);
                    break;
                case 'overview':
                    applyHeightOverview(line);
                    break;
            }
        }

    }

    function applyStateBarChar(rider) {

        pedaladas_barChart.forEach(element => {

            d3.select('#' + element.id)
                .attr("line_clicked", element.line_clicked)
                .attr("color_selected", element.color_selected)
                .attr("distance", element.distance)
                .attr("rider", element.rider)
                .attr("title", element.distance.toFixed(2) + " KM")
                .attr("style", element.style);

            adjustHeightLine('#' + element.id);


        });

        if (switchToggle == 'overview') {
            let box = extractBox(pedaladas_barChart, rider);
            if (box.length > 0) {
                let element = box[0];
                let parent = $("#" + element.id).parent().attr('id');
                let height_box = parseInt(d3.select('#' + parent).style('height').replace('px', ''));
                d3.select('#' + parent).style('height', (height_box + (box.length * 14)) + 'px')
            }

        }

    }

    function extractBox(arr, value) {

        return arr.filter(function(ele) {
            return ele.rider === value;
        });
    }
</script>