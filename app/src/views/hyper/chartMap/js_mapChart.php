<script>
    function resizeMapChart() {
        let heightMapChart = parseInt(heightWindow / 3);
        d3.select('#mapChart').style('height', heightMapChart + 'px');
    }

    function createMapChart() {

        resizeMapChart();

        // Configurações iniciais do Mapa
        let mapCenter;
        let zoomInitial;
        let layer = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png'

        var map = L.map('mapChart').setView([51.505, -0.09], 13);
        var tiles = L.tileLayer(layer, {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        totalStorage(); // Monitorando Storage

    }
</script>