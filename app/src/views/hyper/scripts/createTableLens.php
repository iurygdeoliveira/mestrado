<script>
    function createTableLens(pedaladas, index, rider) {
        // console.log(pedaladas);
        // console.log(rider)

        // Obtendo cores dos ciclistas dos checkbox
        let color = $('#' + rider).attr('style').replace(";", "").replace("background-color: ", "");
        //console.log(color);

        // Atribuindo tooltip
        let number_rider = rider.replace("rider", "");
        $('#svg' + index + '_tooltip').attr('title', "Ciclista " + number_rider);

        // Obtendo faixa de distância
        let range_min = parseFloat($('#range-min').text());
        let range_max = parseFloat($('#range-max').text());
        console.log("Tamanho Maximo:", range_max, "Tamanho mínimo:", range_min);

        // Convertendo para formato numérico
        pedaladas.forEach(element => {
            element.distance_haversine = parseFloat(element.distance_haversine)
        });

        // Ordenando elementos
        pedaladas = arraySort(switchOrder, pedaladas);
        //console.log("Pedaladas:", pedaladas);

        // Delimitando pedaladas dentro da faixa de distância escolhida
        let pedaladas_selected = [];
        for (var i = 0; i < pedaladas.length; i++) {
            if ((pedaladas[i].distance_haversine > range_min) && (pedaladas[i].distance_haversine < range_max)) {
                pedaladas_selected.push(pedaladas[i]);

            }

        }

        // Ativar apenas para auxiliar no desenho de linhas
        //*************************************************
        pedaladas_selected = pedaladas_selected.splice(0, 5);
        //*************************************************

        store.session.set(rider + '_selected', {
            pedaladas_selected
        });

        // Obtendo maior pedaladas do ciclista
        let maxDistanceRider = Math.max(...pedaladas_selected.map(obj => obj.distance_haversine))
        //console.log("Maior Distância do ciclista", maxDistanceRider);

        // Desenhando linhas
        if (switchToggle == 'item') {
            drawItens(index, color, pedaladas_selected, maxDistanceRider, rider).then(() => {
                animationTableLens();
            });
        }
        if (switchToggle == 'overview') {
            drawOverview(index, color, pedaladas_selected, maxDistanceRider, rider);
        }
    }

    function sizeMax(line_size, distanceMaxRider) {

        return Math.round((line_size * 194) / distanceMaxRider) + 4;
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

    function drawLines(svg, distance_pedalada, id_pedalada, x1, line, maxDistanceRider, rider, background, width) {

        let line_size = Math.round(parseFloat(distance_pedalada));

        svg.append('g')
            .attr("id", rider + "_pedalada_" + id_pedalada + "_group")
            .append('line')
            .style("stroke", background)
            .style("stroke-width", width)
            .attr("id", rider + "_pedalada_" + id_pedalada)
            .attr("pedalada_clicada", false)
            .attr("distance", distance_pedalada)
            .attr("x1", x1)
            .attr("y1", line)
            .attr("x2", sizeMax(line_size, maxDistanceRider))
            .attr("y2", line);

        distance_pedalada = parseFloat(distance_pedalada).toFixed(2);
        d3.select('#' + rider + "_pedalada_" + id_pedalada).text("id: " + id_pedalada + " " + distance_pedalada + " KM");
        //$('#' + rider + "_pedalada_" + id_pedalada).text("id: " + id_pedalada + " " + distance_pedalada + " KM");


    }

    async function drawItens(index, color, pedaladas, maxDistanceRider, rider) {

        let svg = drawSVG(index, color);

        let count_lines = 0;
        let line = y_pos_inicial;
        let x1 = 4;
        let distance_pedalada = 0;
        let id_pedalada = 0;
        for (; count_lines < pedaladas.length; count_lines++, line += margin_lens) {

            distance_pedalada = pedaladas[count_lines].distance_haversine;
            id_pedalada = pedaladas[count_lines].id;
            drawLines(svg, distance_pedalada, id_pedalada, x1, line, maxDistanceRider, rider, background_lens, min_height_lens)

        }

        d3.select('#svg' + index)
            .style('height', (line - diff_height_box) + 'px');

    }

    function drawOverview(index, color, pedaladas, maxDistanceRider, rider) {

        let svg = drawSVG(index, color);

        let count_overview = 0;
        let line = 4;
        let x1 = 4;
        let distance_pedalada = 0;
        let id_pedalada = 0;
        for (; count_overview < pedaladas.length; count_overview++, line += 1) {

            distance_pedalada = pedaladas[count_overview].distance_haversine;
            id_pedalada = pedaladas[count_overview].id;
            drawLines(svg, distance_pedalada, id_pedalada, x1, line, maxDistanceRider, rider, 'rgb(0,0,0)', 0.5);

        }

        d3.select('#svg' + index)
            .style('height', (line + 3) + 'px')
            .style('top', '0px');

    }

    function arraySort(mode, pedaladas) {

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
</script>