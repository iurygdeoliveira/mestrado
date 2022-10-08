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
            return value.substring(0, 13);
        }
        return value;
    }

    function parseCentroid(centroid) {

        console.log(centroid);
        let aux1 = centroid.replace('[', '').replace(']', '');
        //centroid = aux1.split(',');
        let aux2 = aux1.split(',');

        aux2[0] = parseFloat(limitTamString(aux2[0], 14));
        aux2[1] = parseFloat(limitTamString(aux2[1], 14));
        return aux2;
    }

    function calculateMapCenter() {

        let pedaladas_mapChart = store.session.get('pedaladas_mapChart');

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
            let layer = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png'

            var map = L.map('pedaladas_mapChart').setView(mapCenter, zoomInitial);
            var tiles = L.tileLayer(layer, {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

        });
    }

    function setCoordinates(element) {

        let aux = extractPedalada(store.session.get('pedaladas_coordinates'), element);
        return {
            'point': aux[0].pointInitial,
            'bbox': aux[0].bbox,
            'centroid': aux[0].centroid
        };

    }

    function mount_pedaladas_mapChart(pedaladas_barChart) {

        let aux = [];

        pedaladas_barChart.forEach(element => {

            if (element.line_clicked == 'true') {

                let coordinates = setCoordinates(element);
                aux.push({
                    'id': element.id,
                    'rider': element.rider,
                    'color_selected': element.color_selected,
                    'distance': element.distance,
                    'pointInitial': coordinates.point,
                    'bbox': coordinates.bbox,
                    'centroid': coordinates.centroid
                });
            }
        });

        return aux;
    }

    async function updateMapChart(pedaladas_barChart) {

        store.session.set('pedaladas_mapChart', mount_pedaladas_mapChart(pedaladas_barChart));
        console.log('Atualizando map Chart');
        console.log('Pedaladas map Chart armazenadas', store.session.get('pedaladas_mapChart'));
        removeMapChart();
        createMapChart();
        totalStorage(); // Monitorando Storage
    }
</script>