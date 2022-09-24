<script>
    async function verPedaladas() {

        console.log("Ciclistas Selecionados");
        console.log(selected);
        //console.log(distances);

        // Limpando conteudo dos svg's
        d3.select('#svg0').remove();
        d3.select('#svg1').remove();
        d3.select('#svg2').remove();
        d3.select('#svg3').remove();
        d3.select('#svg4').remove();


        for (let count_pedaladas = 0; count_pedaladas < selected.length; count_pedaladas++) {

            let svg_aux = '';

            // Ajustando left para cada box
            if (count_pedaladas == 0) {
                svg_aux = d3.select('#svg' + count_pedaladas + '_tooltip').style("top", (y_top) + 'px');
                svg_aux.style("top", (y_top) + 'px');
            }
            if (count_pedaladas == 1) {
                svg_aux = d3.select('#svg' + count_pedaladas + '_tooltip');
                svg_aux.style("left", '215px').style("top", (y_top) + 'px');
            }
            if (count_pedaladas == 2) {
                svg_aux = d3.select('#svg' + count_pedaladas + '_tooltip');
                svg_aux.style("left", '424px').style("top", (y_top) + 'px');
            }
            if (count_pedaladas == 3) {
                svg_aux = d3.select('#svg' + count_pedaladas + '_tooltip');
                svg_aux.style("left", '633px').style("top", (y_top) + 'px');
            }
            if (count_pedaladas == 4) {
                svg_aux = d3.select('#svg' + count_pedaladas + '_tooltip');
                svg_aux.style("left", '842px').style("top", (y_top) + 'px');
            }

            svg_aux.append('svg')
                .attr("id", "svg" + count_pedaladas);
        }

        // Criando o Table Lens
        for (count_pedaladas = 0; count_pedaladas < selected.length; count_pedaladas++) {
            createTableLens(store.session.get(selected[count_pedaladas]).distances, count_pedaladas, selected[count_pedaladas]);
        }

        enableTooltips();

    }
</script>