<script>
    async function resizeMapChart() {
        let heightMapChart = parseInt(heightWindow / 2) - adjustHeightCharts;
        removeMapChart();
        d3.select('#mapChart').style('height', heightMapChart + 'px')
            .append('div')
            .attr("id", 'pedaladas_mapChart');
    }

    function removeMapChart() {
        d3.select('#pedaladas_mapChart').remove();
    }

    async function calculateMapCenter(pedaladas) {

        let centroids = [];
        let bounds;

        const promises = pedaladas.map(async (pedalada_current, idx) => {
            centroids.push(pedalada_current.centroid);
        });

        await Promise.all(promises);

        switch (centroids.length) {
            case 0:
                map.setView([0, 0], initialZoom);
                break;
            case 1:
                map.setView(centroids[0], 8);
                break;
            default:
                bounds = new L.LatLngBounds(centroids)
                map.fitBounds(bounds);
                break;
        }

        return map;
    }

    function mountTile() {

        return L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}.png', {
            minZoom: minZoom,
            maxZoom: maxZoom,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });

        // http://basemap.nationalmap.gov/arcgis/rest/services/USGSTopo/MapServer/tile/{z}/{y}/{x}
        // http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}
        // http://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}.png
        // http://{s}.google.com/vt/lyrs=pl&x={x}&y={y}&z={z}
        // https://elevation-tiles-prod.s3.amazonaws.com/terrarium/${coords.z}/${coords.x}/${coords.y}.png

    }

    async function addLayerDistance(map, route, distance, hotline) {

        var stateChangingButton = L.easyButton({
            states: [{
                stateName: 'see-distances', // name the state
                icon: 'mdi mdi-18px mdi-alpha-d-box', // and define its properties
                title: 'See distances', // like its title
                onClick: function(btn, map) { // and its callback
                    distance.addTo(map);
                    route.removeFrom(map);
                    hotline.removeFrom(map);
                    btn.state('see-distances'); // change state on click!
                }
            }]
        });

        stateChangingButton.addTo(map);

    }

    async function addLayerRoute(map, route, distance, hotline) {

        var stateChangingButton = L.easyButton({
            states: [{
                stateName: 'see-routes', // name the state
                icon: 'mdi mdi-18px mdi-alpha-r-box', // and define its properties
                title: 'See Routes', // like its title
                onClick: function(btn, map) { // and its callback
                    route.addTo(map);
                    distance.removeFrom(map);
                    hotline.removeFrom(map);
                    btn.state('see-routes'); // change state on click!
                }
            }]
        });

        stateChangingButton.addTo(map);
    }

    async function addLayerHotline(map, route, distance, hotline) {

        var stateChangingButton = L.easyButton({
            states: [{
                stateName: 'see-hotline', // name the state
                icon: 'mdi mdi-18px mdi-alpha-h-box', // and define its properties
                title: 'See hotline', // like its title
                onClick: function(btn, map) { // and its callback
                    hotline.addTo(map);
                    distance.removeFrom(map);
                    route.removeFrom(map);
                    btn.state('see-hotline'); // change state on click!
                }
            }]
        });

        stateChangingButton.addTo(map);
    }

    async function enableTooltipMap() {

        await enableTipsyTooltip(
            ".easy-button-button.leaflet-bar-part.leaflet-interactive",
            'right'
        );
        await enableTipsyTooltip(
            ".leaflet-control-fullscreen-button.leaflet-bar-part",
            'right'
        );
        await enableTipsyTooltip(
            ".leaflet-control-zoom-in",
            'right'
        );
        await enableTipsyTooltip(
            ".leaflet-control-zoom-out",
            'right'
        );
    }

    async function defineLayer(route, distance, hotline, pedaladas) {


        var routeLayer = mountTile();
        var distanceLayer = mountTile();
        var hotlineLayer = mountTile();

        const baseLayers = {
            'Distance': distanceLayer,
            'Route': routeLayer,
            'Hotline': hotlineLayer
        };

        map = L.map('pedaladas_mapChart', {
            fullscreenControl: true,
            layers: [distanceLayer, routeLayer, hotlineLayer]
        });

        hotline.addTo(map);
        await addLayerHotline(map, route, distance, hotline);
        await addLayerRoute(map, route, distance, hotline);
        await addLayerDistance(map, route, distance, hotline);
        await enableTooltipMap();

        return map;

    }

    async function updateMapChart() {

        console.log("Update MapChart ...");
        await resizeMapChart();

        if (betweenPointsGroup != null) {
            betweenPointsGroup.removeFrom(distanceMap);
            betweenPointsGroup = null;
        }

        route = await plotLines(pedaladas_barChart, route);
        route = await plotMarkles(pedaladas_barChart, route);
        distanceMap = await plotDistance(pedaladas_barChart, distanceMap);
        hotline = await plotHotline(pedaladas_barChart, hotline);
        let map = await defineLayer(route, distanceMap, hotline, pedaladas_barChart);
        let centerMap = await calculateMapCenter(pedaladas_barChart);
    }
</script>