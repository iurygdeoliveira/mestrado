<script>
    function updateSlider(selected) {

        console.log("updateSlider | Start");
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

        console.log("updateSlider | End");

    }

    function updatingSlider() {
        console.log("updatingSlider | start");

        if (distances.length == 0) {
            $("#range-max").text("?");
        } else {
            const maxDistance = distances.reduce(function(prev, current) {
                return prev > current ? prev : current;
            });
            console.log("Maior Distância: ", maxDistance);
            $("#range-max").text(maxDistance);
            updateRangeMax(maxDistance);
        }
        console.log("updatingSlider | end");
    }

    function updateRangeMax(maxDistance) {
        console.log("updateRangeMax | Start");
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
        console.log("updateRangeMax | End");
    }
</script>