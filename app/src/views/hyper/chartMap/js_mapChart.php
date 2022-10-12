<script>
    async function resizeMapChart() {
        let heightMapChart = parseInt(heightWindow / 3);
        d3.select('#mapChart').style('height', heightMapChart + 'px')
            .append('div')
            .attr("id", 'pedaladas_mapChart')
            .attr('class', 'p-0 m-0');
    }

    function removeMapChart() {
        d3.select('#pedaladas_mapChart').remove();
    }


    // Calculando o centroid de cada bounding box das pedaladas selecionadas
    function limitTamString(value, tam) {

        if (value.lenght > tam) {
            return value.substring(0, 9);
        }
        return value;
    }

    function parseCentroid(centroid) {

        let aux1 = centroid.replace('[', '').replace(']', '');
        let aux2 = aux1.split(',');

        aux2[0] = parseFloat(limitTamString(aux2[0], 10));
        aux2[1] = parseFloat(limitTamString(aux2[1], 10));
        return aux2;
    }

    function calculateMapCenter() {

        let centroids = [];
        pedaladas_mapChart.forEach(element => {
            centroids.push(parseCentroid(element.centroid))
        });
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

    function createMapChart() {

        resizeMapChart().then(() => {

            let mapCenter = calculateMapCenter();
            // Configurações iniciais do Mapa
            console.log(mapCenter);
            let zoomInitial = 5;
            let minZoom;
            let maxZoom;

            var map = L.map('pedaladas_mapChart').setView(mapCenter, zoomInitial);
            var tiles = L.tileLayer(layerMap, {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var marker = L.marker(mapCenter).addTo(map);

        });
    }

    async function mount_pedaladas_mapChart(pedaladas_barChart) {

        console.group("MapChart ...");
        console.log("Montando pedaladas mapChart ...");
        // resolvedFlag = false;
        aux = [];

        for (const pedalada_current of pedaladas_barChart) {

            if (pedalada_current.line_clicked == 'true') {
                const result = await new Dexie(pedalada_current.rider).open()
                    .then(async function(db) {

                        return await getCoordinates_in_DB(db, pedalada_current).then((coordinates) => {
                            console.log("Retorno da consulta ao indexedDB: ", coordinates);
                            return coordinates;
                        }); // getCoordinates_in_DB
                    }); // new Dexie

                aux.push({
                    'id': pedalada_current.id,
                    'rider': pedalada_current.rider,
                    'color_selected': pedalada_current.color_selected,
                    'distance': pedalada_current.distance,
                    'pointInitial': result[0].pointInitial,
                    'pointFinal': result[0].pointFinal,
                    'points': result[0].points,
                    'centroid': result[0].centroid
                }); // pedaladas_mapChart.push
            }
        }
        return await aux;
    }

    async function updateMapChart() {

        console.log('Pedaladas mapChart armazenadas', pedaladas_mapChart);
        removeMapChart();
        createMapChart();
        console.groupEnd();
        totalStorage(); // Monitorando Storage

    }
</script>