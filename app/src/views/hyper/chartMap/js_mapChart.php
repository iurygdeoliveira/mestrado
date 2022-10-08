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

    function parseBbox(bbox) {
        return [
            parseFloat(parseFloat(bbox.north).toFixed(4)),
            parseFloat(parseFloat(bbox.east).toFixed(4)),
            parseFloat(parseFloat(bbox.south).toFixed(4)),
            parseFloat(parseFloat(bbox.west).toFixed(4))
        ]
    }

    // Calculando o centroid de cada bounding box das pedaladas selecionadas
    function calculateBboxCenter(bbox) {

        let centroid = []
        bbox.forEach(element => {
            console.log(element);
            let polygon = turf.polygon([element]);
            centroid.push(turf.centroid(polygon));
        });
        return centroid;
    }

    function calculateMapCenter() {

        let pedaladas_mapChart = store.session.get('pedaladas_mapChart');

        let bbox = [];
        pedaladas_mapChart.forEach(element => {
            bbox.push(parseBbox(element.bbox))
        });
        let polygonCentroid = calculateBboxCenter(bbox);
        let centroid = turf.centroid(polygonCentroid);

        console.log(bbox);
        console.log(polygonCentroid);
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

            var map = L.map('pedaladas_mapChart').setView([51.505, -0.09], zoomInitial);
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
            'bbox': aux[0].bbox
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
                    'bbox': coordinates.bbox
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