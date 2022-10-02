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

        store.session.set(rider + '_selected', {
            pedaladas_selected
        });

        // Obtendo maior pedaladas do ciclista
        let maxDistanceRider = Math.max(...pedaladas_selected.map(obj => obj.distance_haversine));
        //console.log("Maior Distância do ciclista", maxDistanceRider);

        // Desenhando linhas
        if (switchToggle == 'item') {
            drawItens(index, color, pedaladas_selected, maxDistanceRider, rider, 6, 1, 15).then(() => {
                animationTableLens();
            });
        }

        if (switchToggle == 'overview') {
            drawItens(index, color, pedaladas_selected, maxDistanceRider, rider, 0, 0, 2).then(() => {
                animationTableLens();
            });
            //drawOverview(index, color, pedaladas_selected, maxDistanceRider, rider);
        }

    }

    function widthLine(distance, distanceMaxRider) {

        return parseFloat((100 * distance) / distanceMaxRider);
    }

    function drawLines(box, color, rider, distance_pedalada, id_pedalada, maxDistanceRider, padding, marginBottom) {

        let tamLine = widthLine(distance_pedalada, maxDistanceRider);

        d3.select('#' + box)
            .append('div')
            .attr("id", rider + "_pedalada_" + id_pedalada)
            .attr("box", box)
            .attr("color_main", color)
            .attr("line_clicked", 'false')
            .attr("color_selected", 'false')
            .attr("distance", distance_pedalada)
            .attr("title", distance_pedalada.toFixed(2) + " KM")
            .style('display', 'block')
            .style('width', tamLine + '%')
            .style('background-color', background_lens)
            .style('padding', padding + 'px')
            .style('margin-bottom', marginBottom + 'px')
            .style('border', '0.1px solid ' + background_lens);
    }

    function resizeHeight(index, count, fator) {

        d3.select('#table_lens_box_' + index)
            .style('height', ((count * fator) + 17) + 'px');
    }

    async function drawItens(index, color, pedaladas, maxDistanceRider, rider, padding, marginBottom, factor) {

        let box = 'table_lens_box_' + index;
        let distance_pedalada = 0;
        let id_pedalada = 0;
        let count = 0;
        // let padding = 6;
        // let marginBottom = 1;
        for (; count < pedaladas.length; count++) {

            distance_pedalada = pedaladas[count].distance_haversine;
            id_pedalada = pedaladas[count].id;
            drawLines(
                box,
                color,
                rider,
                distance_pedalada,
                id_pedalada,
                maxDistanceRider,
                padding,
                marginBottom
            );
        }

        resizeHeight(index, count, factor);

    }

    // function drawOverview(index, color, pedaladas, maxDistanceRider, rider) {

    //     let box = 'table_lens_box_' + index;
    //     let distance_pedalada = 0;
    //     let id_pedalada = 0;
    //     let count = 0;
    //     let padding = 0;
    //     let marginBottom = 0;
    //     for (; count < pedaladas.length; count++) {

    //         distance_pedalada = pedaladas[count].distance_haversine;
    //         id_pedalada = pedaladas[count].id;
    //         drawLines(
    //             box,
    //             color,
    //             rider,
    //             distance_pedalada,
    //             id_pedalada,
    //             maxDistanceRider,
    //             padding,
    //             marginBottom
    //         );
    //     }

    //     resizeHeight(index, count, 2);

    // }

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