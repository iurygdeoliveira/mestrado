<script>
    function createTableLens(pedaladas, index, rider, maxDistance) {
        // console.log(pedaladas);
        // console.log(rider)

        // Obtendo cores dos ciclistas
        let color = $('#' + rider).attr('style').replace(";", "").replace("background-color: ", "");
        //console.log(color);

        // Atribuindo tooltip
        let number_rider = rider.replace("rider", "");
        $('#svg' + index + '_tooltip').attr('title', "Ciclista " + number_rider);

        // Desenhando linhas
        console.log();
        $('#switchToggle').on('click', function() {

        });
        drawItens(index, color, pedaladas, maxDistance, rider);
        //drawCircle();
    }

    function drawItens(index, color, pedaladas, maxDistance, rider) {

        let svg = d3.select('#svg' + index)
            .style('background-color', 'rgb(255,255,255)')
            .style('outline', '3px solid ' + color)
            .style('padding', '0px')
            .style('margin-right', '5px')
            .style('margin-bottom', '5px')
            .style('width', '201px');

        let count = 0;
        let line = 4;
        for (; count < pedaladas.length; count++, line += 5) {

            let line_size = Math.round(parseFloat(pedaladas[count].distance_haversine));

            svg.append('line')
                .style("stroke", background_lens)
                .style("stroke-width", mix_height_lens)
                .attr("id", rider + "_pedalada_" + pedaladas[count].id)
                .attr("distance", pedaladas[count].distance_haversine)
                .attr("x1", 4)
                .attr("y1", line)
                .attr("x2", (Math.round((line_size * 194) / maxDistance) + 4))
                .attr("y2", line);
        }

        d3.select('#svg' + index)
            .style('height', line + 'px')
            .style('top', '0px');

    }

    // function drawCircle() {

    //     let svg = d3.select('#svg1')
    //         .attr('viewBox', [0, 0, 205, 210])
    //         .attr('width', '100%')
    //         .style('background-color', 'rgb(255,255,255)')
    //         .style('outline', '3px solid rgb(211, 69, 91)')
    //         .style('padding', '0px')
    //         .style('height', '200px');



    //     let cx = 7;
    //     let cy = 7;

    //     for (let column = 0; column < 20; column++, cx += 11) {
    //         svg
    //             .append('circle')
    //             .attr('cx', cx)
    //             .attr('cy', cy)
    //             .attr('r', 5)
    //             .style('fill', 'rgb(90, 90, 90)');

    //     }

    //     cx = 7;
    //     cy = 18;

    //     for (let line = 0; line < 18; line++, cy += 11) {
    //         svg
    //             .append('circle')
    //             .attr('cx', cx)
    //             .attr('cy', cy)
    //             .attr('r', 5)
    //             .style('fill', 'red');
    //     }
    // }
</script>