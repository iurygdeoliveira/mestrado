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

        // Ordenando elementos
        pedaladas = arraySort(switchOrder, pedaladas);
        console.log(pedaladas);

        // Desenhando linhas
        if (switchToggle == 'item') {
            drawItens(index, color, pedaladas, maxDistance, rider);
        }
        if (switchToggle == 'overview') {
            drawOverview(index, color, pedaladas, maxDistance, rider);
        }
    }

    function arraySort(mode, pedaladas) {

        // Convertendo para formato numérico
        pedaladas.forEach(element => {
            element.distance_haversine = parseFloat(element.distance_haversine)
        });

        if (mode == 'descending') {

            pedaladas.sort(function(a, b) {
                if (a.distance_haversine < b.distance_haversine) {
                    return 1;
                }
                if (a.distance_haversine > b.distance_haversine) {
                    return -1;
                }
                // a must be equal to b
                return 0;
            });

            return pedaladas;
        }
        if (mode == 'ascending') {

            pedaladas.sort(function(a, b) {
                if (a.distance_haversine > b.distance_haversine) {
                    return 1;
                }
                if (a.distance_haversine < b.distance_haversine) {
                    return -1;
                }
                // a must be equal to b
                return 0;
            });

            return pedaladas;

        }
    }

    function sizeMax(line_size, maxDistance) {

        return Math.round((line_size * 194) / maxDistance) + 4;
    }

    function drawSVG(index, color) {

        return d3.select('#svg' + index)
            .style('background-color', 'rgb(255,255,255)')
            .style('outline', '3px solid ' + color)
            .style('padding', '0px')
            .style('margin-right', '5px')
            .style('margin-bottom', '5px')
            .style('width', '201px');
    }

    function drawItens(index, color, pedaladas, maxDistance, rider) {

        let svg = drawSVG(index, color);

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
                .attr("x2", sizeMax(line_size, maxDistance))
                .attr("y2", line);
        }

        d3.select('#svg' + index)
            .style('height', line + 'px')
            .style('top', '0px');

    }

    function drawOverview(index, color, pedaladas, maxDistance, rider) {

        let svg = drawSVG(index, color);

        let count = 0;
        let line = 4;
        for (; count < pedaladas.length; count++, line += 1) {

            let line_size = Math.round(parseFloat(pedaladas[count].distance_haversine));

            svg.append('line')
                .style("stroke", 'rgb(0,0,0)')
                .style("stroke-width", 0.5)
                .attr("id", rider + "_pedalada_" + pedaladas[count].id)
                .attr("distance", pedaladas[count].distance_haversine)
                .attr("x1", 4)
                .attr("y1", line)
                .attr("x2", sizeMax(line_size, maxDistance))
                .attr("y2", line);
        }

        d3.select('#svg' + index)
            .style('height', line + 'px')
            .style('top', '0px');

    }
</script>