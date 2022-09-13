<script>
    async function updateSlider(selected) {

        //console.log(selected)

        distances = [];
        selected.forEach(rider => {

            // console.log(rider);
            // console.log(store.session.has(rider));
            if (store.session.has(rider)) {

                if (store.session.get(rider).maxDistance <= 0) {
                    console.log('Erro na distância máxima do' + rider);
                }

                if (store.session.get(rider).maxDistance > 0) {
                    distances.push(Math.trunc(store.session.get(rider).maxDistance));
                }
            } else {
                console.log('Erro na distância máxima do' + rider);
            }

        });

        // Encontrando o maior valor

        // Atualizando slider
        console.log("Distancias selecionadas: ", distances);
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