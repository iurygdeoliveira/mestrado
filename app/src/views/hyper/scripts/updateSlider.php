<script>
    async function updateSlider(selected) {

        let distanceSlider = [];
        console.group("Update slider ...");
        console.groupEnd();

        // Atualizando distancias
        for (const rider of selected) {

            let has = await hasDistanceCyclist(rider);
            if (has) {
                let maxDistance = await filterMaxDistance(rider);
                if (maxDistance <= 0) {
                    console.log('Error in the maximum distance of the cyclist' + rider);
                } else {
                    distanceSlider.push(maxDistance);
                }
            }
        }

        updatingSlider(distanceSlider);

        d3.selectAll('.ui-slider-handle').on('mouseup', function() {
            updateButtonSearchRiders(selected, false, true, false);

            removeBarChart();
            pedaladas_barChart = [];
            pedaladas_red_clicadas = 0;
            pedaladas_blue_clicadas = 0;
            pedaladas_yellow_clicadas = 0;
            pedaladas_green_clicadas = 0;
            pedaladas_purple_clicadas = 0;

            tableLens().then(() => {
                updateButtonSearchRiders(selected, true, false, false);
            });
            d3.select('#search_rides').attr('title', 'See Table Lens');
        });
    }

    function updatingSlider(distanceSlider) {


        if (distanceSlider.length > 0) {

            d3.select("#distance")
                .style("display", 'block');
            //distances = distances.map(Number);
            let maxDistance = distanceSlider.reduce(function(a, b) {
                return Math.max(a, b)
            });

            //console.log("Distâncias: ", distances);
            //console.log("Maior Distância: ", maxDistance);
            d3.select("#range-max").text(maxDistance);
            updateRangeMax(maxDistance);

        } else {
            d3.select("#distance")
                .style("display", 'none');
        }


    }

    function updateRangeMax(maxDistance) {

        $("#slider-range").slider({
            range: true,
            min: 5,
            step: 0.01,
            max: maxDistance,
            values: [5, maxDistance],
            slide: function(event, ui) {
                d3.select("#range-min").text(ui.values[0]);
                d3.select("#range-max").text(ui.values[1]);
            }
        });

    }
</script>