<script>
    async function storeDistance(rider) {

        if (!store.session.has(rider)) {
            let distances = await getDistances(rider);
            store.session.set(rider, {
                distances: distances,
                maxDistance: await getMaxDistance(distances),
            });
            return;
        }

        if (store.session.get(rider).maxDistance <= 0) {
            console.log('Erro na distância máxima do' + rider);
            return;
        }

        if (store.session.get(rider).maxDistance > 0) {
            console.log('Distância máxima do ' + rider + ' presente no storage');
            return;
        }

        if (store.session.get(rider).distances.length < 0) {
            console.log('Erro na captura de distâncias do ' + rider);
            return;
        }

        if (store.session.get(rider).distances.length > 0) {
            console.log('Distâncias do ' + rider + ' presente no storage');
            return;
        }

    }

    async function getMaxDistance(distances) {
        return await Math.max(...distances.map(obj => obj.distance));
    }

    async function getDistances(cyclist) {

        console.log("Cyclist " + cyclist.replace(/[^0-9]/g, '') + " without distances");
        let distances = await getDistancesGithub(cyclist);
        return distances;
    }
</script>