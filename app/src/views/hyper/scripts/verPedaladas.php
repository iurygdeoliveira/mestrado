<script>
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
                .style('background-color', 'rgb(255, 255, 255)')
                .style('border', '3px solid ' + color)
                .style('border-radius', '0.25rem');
        }

    }

    async function createSkeleton() {

        createLabels();
        createBox();
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

    async function verPedaladas() {

        console.log("Ciclistas Selecionados");
        console.log(selected);

        // Limpando conteudo dos svg's
        console.log('Criando esqueleto do table lens');
        removeTableLens();
        createSkeleton().then(() => {

            console.log('Criando table lens');
            for (let count_pedaladas = 0; count_pedaladas < selected.length; count_pedaladas++) {
                createTableLens(store.session.get(selected[count_pedaladas]).distances, count_pedaladas, selected[count_pedaladas]);
            }
            enableTooltips();

        });



    }
</script>