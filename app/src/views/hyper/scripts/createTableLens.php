<script>
    async function createTableLens(pedaladas, index, rider) {
        //console.log(pedaladas.length);
        //console.log(rider)

        // Obtendo cores dos ciclistas
        let color = $('#' + rider).attr('style').replace(";", "").replace("background-color: ", "");
        //console.log(color);

        // Atribuindo tooltip
        let number_rider = rider.replace("rider", "");
        $('#svg' + index + '_tooltip').attr('title', "Ciclista " + number_rider);

        // Desenhando Table lens
        drawLines(index, color);
        //drawCircle();
    }

    function drawLines(index, color) {

        let svg = d3.select('#svg' + index)
            .style('background-color', 'rgb(255,255,255)')
            .style('outline', '3px solid ' + color)
            .style('padding', '0px')
            .style('margin-right', '5px')
            .style('height', '5000px')
            .style('width', '201px');

        let count = 0;
        let line = 4;
        // 49
        for (; count < 900; count++, line += 4) {

            svg.append('line')
                .style("stroke", 'rgb(40,40,40)')
                .style("stroke-width", 2)
                .attr("x1", 4)
                .attr("y1", line)
                .attr("x2", 197)
                .attr("y2", line);
        }

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