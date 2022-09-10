<script>
    async function createTableLens(pedaladas) {
        //console.log(pedaladas);
        // updateButtonCreateVis(pedaladas)
        //drawLine();
        //drawCircle();
    }

    function drawCircle() {

        let svg = d3.select('#svg1')
            .attr('viewBox', [0, 0, 205, 210])
            .attr('width', '100%')
            .style('background-color', 'rgb(255,255,255)')
            .style('outline', '3px solid rgb(211, 69, 91)')
            .style('padding', '0px')
            .style('height', '200px');



        let cx = 7;
        let cy = 7;

        for (let column = 0; column < 20; column++, cx += 11) {
            svg
                .append('circle')
                .attr('cx', cx)
                .attr('cy', cy)
                .attr('r', 5)
                .style('fill', 'rgb(90, 90, 90)');

        }

        cx = 7;
        cy = 18;

        for (let line = 0; line < 18; line++, cy += 11) {
            svg
                .append('circle')
                .attr('cx', cx)
                .attr('cy', cy)
                .attr('r', 5)
                .style('fill', 'red');
        }
    }

    function drawLine() {

        let svg = d3.select('#svg1')
            .attr('width', '236')
            .style('background-color', 'rgb(255,255,255)')
            .style('outline', '3px solid rgb(211, 69, 91)')
            .style('padding', '0px')
            .style('height', '225px');


        let index = 0;
        let line = 4;
        // 49
        for (; index < 55; index++, line += 4) {

            svg.append('line')
                .style("stroke", 'rgb(40,40,40)')
                .style("stroke-width", 2)
                .attr("x1", 4)
                .attr("y1", line)
                .attr("x2", 232)
                .attr("y2", line);
        }

    }

    function updateButtonCreateVis(pedaladas) {

        // Atualizando botão de atualizar visualização ao 
        // modficar novamente os ciclistas selecionados
        let buttonCreateVis = $('#create_vis').css("display");
        console.log(buttonCreateVis);
        console.log(pedaladas);
        console.log(pedaladas.length);
        if ((buttonCreateVis == 'block')) {
            $('#create_vis').hide();
            $('#update_vis').show();
        }
        if ((buttonCreateVis == 'none') && (pedaladas.length > 0)) {
            $('#create_vis').show();
            $('#update_vis').hide();
        }

        // Atualizando botão de busca de pedaladas e slider
        //console.log(selected.length)
        // if (selected.length > 0) {
        //     document.getElementById('search_rides').disabled = false;
        //     document.getElementById('search_rides_update').disabled = false;
        // } else {
        //     document.getElementById('search_rides').disabled = true;
        //     document.getElementById('search_rides_update').disabled = true;

        // }

        // if (search_riders) {
        //     $('#search_rides_update').hide();
        //     $('#search_rides_loading').hide();
        //     $('#search_rides_success').hide();
        //     $('#search_rides_danger').hide();
        //     $('#search_rides').show();
        // }

        // if (search_riders_update) {
        //     $('#search_rides_loading').hide();
        //     $('#search_rides_success').hide();
        //     $('#search_rides_danger').hide();
        //     $('#search_rides').hide();
        //     $('#search_rides_update').show();
        // }

        // if (search_riders_loading) {
        //     $('#search_rides').hide();
        //     $('#search_rides_update').hide();
        //     $('#search_rides_success').hide();
        //     $('#search_rides_danger').hide();
        //     $('#search_rides_loading').show();
        // }

        // if (search_riders_success) {
        //     $('#search_rides').hide();
        //     $('#search_rides_update').hide();
        //     $('#search_rides_loading').hide();
        //     $('#search_rides_danger').hide();
        //     $('#search_rides_success').show();
        // }

        // if (search_riders_danger) {
        //     $('#search_rides').hide();
        //     $('#search_rides_update').hide();
        //     $('#search_rides_loading').hide();
        //     $('#search_rides_success').hide();
        //     $('#search_rides_danger').show();
        // }

    }
</script>