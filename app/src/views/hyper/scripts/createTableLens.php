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

        // Ativar apenas para auxiliar no desenho de linhas
        //*************************************************
        // pedaladas_selected = pedaladas_selected.splice(0, 5);
        //*************************************************

        store.session.set(rider + '_selected', {
            pedaladas_selected
        });

        // Obtendo maior pedaladas do ciclista
        let maxDistanceRider = Math.max(...pedaladas_selected.map(obj => obj.distance_haversine));
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

        // Se houver pedaladas selecionadas, aplicar estado
        if (has_pedaladas_barChart()) {

        }
    }

    function widthLine(distance, distanceMaxRider) {

        return parseFloat((100 * distance) / distanceMaxRider);
    }

    function drawSVG(index, color) {

        let widthTable = String(getWidthTable() + 'px');

        return d3.select('#svg' + index)
            .style('background-color', 'rgb(255,255,255)')
            .style('outline', '3px solid ' + color)
            .style('padding', '0px')
            .style('margin-bottom', '5px')
            .style('width', widthTable);
    }

    function drawLines(box, color, rider, distance_pedalada, id_pedalada, maxDistanceRider) {

        let tamLine = widthLine(distance_pedalada, maxDistanceRider);

        d3.select(box)
            .append('div')
            .attr("id", rider + "_pedalada_" + id_pedalada)
            .attr("color", color)
            .style('display', 'block')
            .style('width', tamLine + '%')
            .style('background-color', background_lens)
            .style('border', '0.5px solid ' + background_lens);
    }

    async function getWidthBox() {
        return parseFloat(store.session.get(widthBox));
    }

    async function drawItens(index, color, pedaladas, maxDistanceRider, rider) {

        let svg = drawSVG(index, color);

        console.log(svg);

        let line = y_pos_inicial;
        let x1 = 4;
        let distance_pedalada = 0;
        let id_pedalada = 0;

        for (let count_lines = 0; count_lines < pedaladas.length; count_lines++, line += margin_lens) {

            distance_pedalada = pedaladas[count_lines].distance_haversine;
            id_pedalada = pedaladas[count_lines].id;
            drawLines(svg, distance_pedalada, id_pedalada, x1, line, maxDistanceRider, rider, background_lens, min_height_lens, color)

        }

        d3.select('#svg' + index)
            .style('height', (line - diff_height_box) + 'px');

    }

    function drawOverview(index, color, pedaladas, maxDistanceRider, rider) {

        let box = '#table_lens_box_' + index;
        let distance_pedalada = 0;
        let id_pedalada = 0;
        let count = 0;
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
            );
        }

        d3.select('#table_lens_box_' + index)
            .style('height', ((count * 2) + 17) + 'px');
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