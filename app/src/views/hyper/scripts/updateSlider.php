<script>
    function updateSlider(selected) {

        distances = [];

        // Atualizando distancias
        selected.forEach(rider => {
            // console.log(rider);
            //console.log(store.session.has(rider));
            if (store.session.has(rider)) {

                if (store.session.get(rider).maxDistance <= 0) {
                    console.log('Erro na distância máxima do' + rider);
                } else {
                    distances.push(store.session.get(rider).maxDistance);
                    updatingSlider();
                }
            }
        });


    }

    function updatingSlider() {


        if (distances.length == 0) {
            $("#range-max").text("?");
        } else {

            distances = distances.map(Number);

            maxDistance = distances.reduce(function(a, b) {
                return Math.max(a, b)
            });

            //console.log("Distâncias: ", distances);
            // console.log("Maior Distância: ", maxDistance);
            $("#range-max").text(maxDistance);
            updateRangeMax(maxDistance);
        }

    }

    function updateRangeMax(maxDistance) {

        $("#slider-range").slider({
            range: true,
            min: 0,
            step: 0.01,
            max: maxDistance,
            values: [0, maxDistance],
            slide: function(event, ui) {
                $("#range-min").text(ui.values[0]);
                $("#range-max").text(ui.values[1]);
            }
        });

    }
</script>