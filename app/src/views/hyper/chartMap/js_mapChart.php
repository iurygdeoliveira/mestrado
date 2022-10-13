<script>
    async function resizeMapChart() {
        let heightMapChart = parseInt(heightWindow / 3);
        removeMapChart();
        d3.select('#mapChart').style('height', heightMapChart + 'px')
            .append('div')
            .attr("id", 'pedaladas_mapChart')
            .attr('class', 'p-0 m-0');
    }

    function removeMapChart() {
        d3.select('#pedaladas_mapChart').remove();
    }


    async function calculateMapCenter(pedaladas_barChart) {

        console.log("Calculando map center ...");
        let centroids = [];

        for (const pedalada_current of pedaladas_barChart) {

            const db = await new Dexie(pedalada_current.rider).open()
                .then(async function(db) {

                    const result = await getCoordinates_in_DB(db, pedalada_current).then(async (result) => {
                        console.log("Retorno da consulta ao indexedDB: ", result);
                        if (!result) {
                            console.log(`Pontos da Pedalada ${pedalada_current.id} não encontrados`);
                        } else {
                            centroids.push(result[0].centroid);
                        }
                        return result;
                    }); // getCoordinates_in_DB

                    return db;
                }); // new Dexie

        } // for

        console.log('Centroids', centroids)
        if (centroids.length > 1) {
            let lineCentroid = turf.lineString(centroids);
            let bboxCentroid = turf.bbox(lineCentroid);
            let polygonCentroid = turf.bboxPolygon(bboxCentroid);
            return turf.centroid(polygonCentroid).geometry.coordinates;
        } else {
            return centroids[0];
        }

    }

    async function defineLayer(pedaladas_barChart) {

        return await calculateMapCenter(pedaladas_barChart).then((mapCenter) => {

            map = L.map('pedaladas_mapChart').setView(mapCenter, initialZoom);
            var tiles = L.tileLayer(layerMap, {
                minZoom: minZoom,
                maxZoom: maxZoom,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var marker = L.marker(mapCenter).addTo(map);
            return map;
        });

    }

    async function plotLines(pedaladas_barChart) {

        console.log("Plotando linestring ...");
        for (const pedalada_current of pedaladas_barChart) {

            await new Dexie(pedalada_current.rider).open()
                .then(async function(db) {

                    return await getCoordinates_in_DB(db, pedalada_current).then(async (result) => {
                        console.log("Retorno da consulta ao indexedDB: ", result);
                        if (!result) {
                            console.log(`Pontos da Pedalada ${pedalada_current.id} não encontrados`);
                        } else {

                            var polyline = L.polyline(result[0].points, {
                                color: pedalada_current.rider.color_selected
                            }).addTo(map);

                            map.fitBounds(polyline.getBounds());
                        }
                    }); // getCoordinates_in_DB
                }); // new Dexie
        } // for
    } // plotLines

    async function updateMapChart() {

        console.group("MapChart ...");
        console.log("Atualizando MapChart ...");

        resizeMapChart();
        defineLayer(store.session.get('pedaladas_barChart')).then((map) => {
            //plotLines(store.session.get('pedaladas_barChart'));
        });

        console.groupEnd();
        totalStorage(); // Monitorando Storage

    }
</script>