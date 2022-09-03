<script>
    async function getDistances(rider) {
        if (store.session.has(rider)) {

            if (store.session.get(rider).maxDistance <= 0) {
                console.log('Erro na distância máxima do' + rider);
                return -1;
            }

            if (store.session.get(rider).maxDistance > 0) {
                return store.session.get(rider).maxDistance;
            }
        } else {
            // Se distância máxima não existir, realiza a busca
            store.session.set(rider, {
                maxDistance: await getMaxDistance(rider)
            });
            return store.session.get(rider).maxDistance;
        }
    }

    async function updateSlider(selected) {

        let distances = [];

        //console.log(selected)
        selected.forEach(rider => {

            if (store.session.has(rider)) {

                if (store.session.get(rider).maxDistance <= 0) {
                    console.log('Erro na distância máxima do' + rider);
                }

                if (store.session.get(rider).maxDistance > 0) {
                    distances.push(store.session.get(rider).maxDistance);
                }
            } else {
                console.log('Erro na distância máxima do' + rider);
            }

        });

        // Encontrando o maior valor

        // Atualizando slider
        console.log(distances);
        if (distances.length == 0) {
            $("#range-max").text("? KM");
        } else {
            const maxDistance = distances.reduce(function(prev, current) {
                return prev > current ? prev : current;
            });
            console.log(maxDistance);
            $("#range-max").text(maxDistance + " KM");
            updateRangeMax(maxDistance);
        }

    }

    function updateRangeMax(maxDistance) {
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: maxDistance,
            values: [0, maxDistance],
            slide: function(event, ui) {
                $("#distance").text(ui.values[0] + " KM - " + ui.values[1] + " KM");
            }
        });
    }
</script>