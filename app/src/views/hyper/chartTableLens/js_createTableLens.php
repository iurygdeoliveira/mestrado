<script>
    async function createTableLens(pedaladas, index, rider) {
        // console.log(pedaladas);
        // console.log(rider)

        // Obtendo cores dos ciclistas dos checkbox
        let color = $('#' + rider).attr('style').replace(";", "").replace("background-color: ", "");
        //console.log(color);

        // Obtendo faixa de distância
        let range_min = parseFloat($('#range-min').text());
        let range_max = parseFloat($('#range-max').text());
        console.log("Maximum distance:", range_max, "Minimum distance:", range_min);

        // Delimitando pedaladas dentro da faixa de distância escolhida
        let pedaladas_selected = [];
        for (var i = 0; i < pedaladas.length; i++) {
            if ((pedaladas[i].distance >= range_min) && (pedaladas[i].distance <= range_max)) {
                pedaladas_selected.push({
                    'distance': pedaladas[i].distance,
                    'id': pedaladas[i].id
                });
            }
        }

        // Ordenando elementos
        pedaladas_selected = arraySort(switchOrder, pedaladas_selected);

        store.session.set(rider + '_selected', {
            pedaladas_selected
        });

        // Obtendo maior pedaladas entre as pedaladas limitadas pelo slider
        let maxDistanceRider = await getMaxDistance(pedaladas_selected);

        // Desenhando linhas
        let factor = 0;
        if (switchToggle == 'item') {
            drawItens(
                    index, color, pedaladas_selected,
                    maxDistanceRider, rider,
                    padding_item, margin_item, 15)
                .then(() => {
                    animationTableLens();
                });
        }
        if (switchToggle == 'overview') {
            drawItens(
                    index, color, pedaladas_selected,
                    maxDistanceRider, rider,
                    padding_overview, margin_overview, 2)
                .then(() => {
                    animationTableLens();
                });
        }
    }

    function widthLine(distance, distanceMaxRider) {

        return parseFloat((100 * distance) / distanceMaxRider);
    }

    function drawLines(box, color, rider, distance_pedalada, id_pedalada, maxDistanceRider, padding, margin) {

        let tamLine = widthLine(distance_pedalada, maxDistanceRider);

        d3.select('#' + box)
            .append('div')
            .attr("id", rider + "_pedalada_" + id_pedalada)
            .attr("rider", rider)
            .attr("line_clicked", 'false')
            .attr("color_selected", 'false')
            .attr("distance", distance_pedalada)
            .attr("title", distance_pedalada.toFixed(2) + " KM")
            .style('display', 'block')
            .style('width', tamLine + '%')
            .style('background-color', background_lens)
            .style('padding', padding)
            .style('margin-bottom', margin)
            .style('margin-top', margin)
            .style('border', '0.1px solid ' + background_lens);
    }

    function resizeHeight(index, count, fator) {

        d3.select('#table_lens_box_' + index)
            .style('height', ((count * fator) + 17) + 'px');

    }

    async function drawItens(index, color, pedaladas, maxDistanceRider, rider, padding, margin, factor) {

        let box = 'table_lens_box_' + index;
        let distance_pedalada = 0;
        let id_pedalada = 0;
        let count = 0;
        for (; count < pedaladas.length; count++) {

            distance_pedalada = pedaladas[count].distance;
            id_pedalada = pedaladas[count].id;

            drawLines(
                box,
                color,
                rider,
                distance_pedalada,
                id_pedalada,
                maxDistanceRider,
                padding,
                margin
            );
        }

        resizeHeight(index, count, factor);

    }

    function arraySort(mode, pedaladas) {

        if (mode == 'descending') {

            pedaladas.sort(function(a, b) {
                if (a.distance < b.distance) {
                    return 1;
                }
                if (a.distance > b.distance) {
                    return -1;
                }
                // a must be equal to b
                return 0;
            });

            return pedaladas;
        }
        if (mode == 'ascending') {

            pedaladas.sort(function(a, b) {
                if (a.distance > b.distance) {
                    return 1;
                }
                if (a.distance < b.distance) {
                    return -1;
                }
                // a must be equal to b
                return 0;
            });

            return pedaladas;

        }
    }
</script>