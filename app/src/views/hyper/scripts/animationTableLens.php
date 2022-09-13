<script>
    function animationTableLens() {
        let lines = d3.selectAll('line')
            .on('mouseover', function() {

                // descobrindo pedalada focada
                let pedalada_mouseover = $(this).attr("id").split("_");
                d3.select(this)
                    .style("stroke", background_lens)
                    .style("stroke-width", max_height_lens);

                // abaixando 20 pixels a posição das pedaladas
                // abaixo da pedalada focada
                let id_pedalada = (parseInt(pedalada_mouseover[2], 10)) + 1;
                let total_pedaladas = store.session.get(pedalada_mouseover[0]).distances.length;

                for (; id_pedalada <= total_pedaladas; id_pedalada++) {

                    let line_modified = '#' + pedalada_mouseover[0] + "_" + pedalada_mouseover[1] + "_" + id_pedalada;
                    let y_pos = parseInt($(line_modified).attr("y1"), 10);
                    d3.select(line_modified)
                        .attr("y1", y_pos + 10)
                        .attr("y2", y_pos + 10);
                }

            })
            .on('mouseout', function() {

                let pedalada_mouseout = $(this).attr("id").split("_");

                d3.select(this)
                    .style("stroke", background_lens)
                    .style("stroke-width", mix_height_lens);

                // subindo 20 pixels a posição das pedaladas
                // abaixo da pedalada focada
                let id_pedalada = (parseInt(pedalada_mouseout[2], 10)) + 1;
                let total_pedaladas = store.session.get(pedalada_mouseout[0]).distances.length;

                for (; id_pedalada <= total_pedaladas; id_pedalada++) {

                    let line_modified = '#' + pedalada_mouseout[0] + "_" + pedalada_mouseout[1] + "_" + id_pedalada;
                    let y_pos = parseInt($(line_modified).attr("y1"), 10);
                    d3.select(line_modified)
                        .attr("y1", y_pos - 10)
                        .attr("y2", y_pos - 10);
                }
            });
    }
</script>