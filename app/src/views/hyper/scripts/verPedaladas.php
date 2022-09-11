<script>
    async function verPedaladas() {

        console.log(selected);

        // Limpando conteudo dos svg's
        d3.select('#svg0').remove();
        d3.select('#svg1').remove();
        d3.select('#svg2').remove();
        d3.select('#svg3').remove();
        d3.select('#svg4').remove();


        for (count = 0; count < selected.length; count++) {
            let svg = d3.select('#svg' + count + '_tooltip');
            svg.append('svg')
                .attr("id", "svg" + count);
        }


        for (count = 0; count < selected.length; count++) {
            await createTableLens(store.session.get(rider).distances, count, selected[count]);
        }

    }
</script>