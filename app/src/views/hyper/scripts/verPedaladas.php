<script>
    async function verPedaladas() {

        console.log("Ciclistas Selecionados");
        console.log(selected);
        //console.log(distances);

        // Obtendo maior pedalada entre as selecionadas
        const maxDistance = distances.reduce(function(prev, current) {
            return prev > current ? prev : current;
        });
        //console.log(maxDistance);

        // Limpando conteudo dos svg's
        d3.select('#svg0').remove();
        d3.select('#svg1').remove();
        d3.select('#svg2').remove();
        d3.select('#svg3').remove();
        d3.select('#svg4').remove();


        for (count = 0; count < selected.length; count++) {
            let svg_aux = d3.select('#svg' + count + '_tooltip');
            svg_aux.append('svg')
                .attr("id", "svg" + count);
        }

        // Criando o Table Lens
        for (count = 0; count < selected.length; count++) {
            createTableLens(store.session.get(selected[count]).distances, count, selected[count], maxDistance);
        }

        if (switchToggle == 'item') {
            animationTableLens();
        }
    }
</script>