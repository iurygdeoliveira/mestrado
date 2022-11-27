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

    }


    async function addLayerDistance(map, route, distance, analysis) {

        var stateChangingButton = L.easyButton({
            states: [{
                stateName: 'see-distances', // name the state
                icon: 'mdi mdi-18px mdi-alpha-d-box', // and define its properties
                title: 'See distances', // like its title
                onClick: function(btn, map) { // and its callback
                    distance.addTo(map);
                    route.removeFrom(map);
                    analysis.removeFrom(map);
                    btn.state('see-distances'); // change state on click!
                }
            }]
        });

        stateChangingButton.addTo(map);

    }

    async function addLayerRoute(map, route, distance, analysis) {

        var stateChangingButton = L.easyButton({
            states: [{
                stateName: 'see-routes', // name the state
                icon: 'mdi mdi-18px mdi-alpha-r-box', // and define its properties
                title: 'See Routes', // like its title
                onClick: function(btn, map) { // and its callback
                    route.addTo(map);
                    distance.removeFrom(map);
                    analysis.removeFrom(map);
                    btn.state('see-routes'); // change state on click!
                }
            }]
        });

        stateChangingButton.addTo(map);
    }

    async function addLayerAnalysis(map, route, distance, analysis) {

        var stateChangingButton = L.easyButton({
            states: [{
                stateName: 'do-analysis', // name the state
                icon: 'mdi mdi-18px mdi-alpha-a-box', // and define its properties
                title: 'Do analysis', // like its title
                onClick: function(btn, map) { // and its callback
                    analysis.addTo(map);
                    distance.removeFrom(map);
                    route.removeFrom(map);
                    btn.state('see-Analysis'); // change state on click!
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

    async function defineLayer(route, distance, analisys, pedaladas) {


        var routeLayer = mountTile();
        var distanceLayer = mountTile();
        //var heatmapLayer = mountTile();

        const baseLayers = {
            'Distance': distanceLayer,
            'Route': routeLayer
            //'Heatmap': heatmapLayer
        };

        map = L.map('pedaladas_mapChart', {
            fullscreenControl: true,
            layers: [distanceLayer, routeLayer]
        });

        route.addTo(map);
        //await addLayerHeatmap(map, route, distance, heatmap);
        await addLayerRoute(map, route, distance, analisys);
        await addLayerDistance(map, route, distance, analisys);
        await enableTooltipMap();

        return map;

    }

    async function plotLines(pedaladas, route) {

        let polyline;
        const promises = pedaladas.map(async (pedalada_current, idx) => {
            polyline = L.polyline(pedalada_current.points, {
                color: pedalada_current.color_selected,
                dashArray: "10 10",
                dashSpeed: 35
            }).addTo(route);
        });

        await Promise.all(promises);

        return route;
    }

    async function plotMarkles(pedaladas, route) {

        const promises = pedaladas.map(async (pedalada_current, idx) => {

            var square = L.shapeMarker(pedalada_current.pointInitial, {
                    color: pedalada_current.color_selected,
                    fillColor: pedalada_current.color_selected,
                    fillOpacity: 0.5,
                    shape: "square",
                    radius: 10
                }).addTo(route)
                .bindPopup(
                    `<b>Start</b><br>
                Datetime: ${pedalada_current.datetime}<br>
                Lat,Lon: ${pedalada_current.pointInitial}<br>
                Avg Heartrate: ${pedalada_current.heartrate_AVG} bpm<br>
                Distance: ${pedalada_current.distance} KM<br>
                Avg Speed: ${pedalada_current.speed_AVG} KM/H<br>
                Duration: ${pedalada_current.duration} <br>
                Country: ${pedalada_current.country}<br>
                Locality: ${pedalada_current.locality}
                `
                );

            var triangle = L.shapeMarker(pedalada_current.pointFinal, {
                color: pedalada_current.color_selected,
                fillColor: pedalada_current.color_selected,
                fillOpacity: 0.5,
                shape: "triangle",
                radius: 10
            }).addTo(route).bindPopup(
                `<b>Finish</b><br>
                Datetime: ${pedalada_current.datetime}<br>
                Lat,Lon: ${pedalada_current.pointFinal}<br>
                Avg Heartrate: ${pedalada_current.heartrate_AVG} bpm<br>
                Distance: ${pedalada_current.distance} KM<br>
                Avg Speed: ${pedalada_current.speed_AVG} KM/H<br>
                Duration: ${pedalada_current.duration} <br>
                Country: ${pedalada_current.country}<br>
                Locality: ${pedalada_current.locality}
                `
            );
        });

        await Promise.all(promises);

        return route;

    }

    async function mountPopup(pedalada_current) {
        return `<b>Start</b><br>
                Datetime: ${pedalada_current.datetime}<br>
                Lat,Lon: ${pedalada_current.pointInitial}<br>
                Avg Heartrate: ${pedalada_current.heartrate_AVG} bpm<br>
                Distance: ${pedalada_current.distance} KM<br>
                Avg Speed: ${pedalada_current.speed_AVG} KM/H<br>
                Duration: ${pedalada_current.duration} <br>
                Country: ${pedalada_current.country}<br>
                Locality: ${pedalada_current.locality}
                `
    }

    async function plotDistanceBetweenPoints(event, distance, points) {

        let pointCurrent = [];

        if (betweenPointsGroup != null) {
            betweenPointsGroup.removeFrom(distance);
            betweenPointsGroup = null;
        }

        betweenPointsGroup = L.featureGroup();

        pointCurrent.push(event.latlng.lat);
        pointCurrent.push(event.latlng.lng);

        L.shapeMarker(pointCurrent, {
            color: line_distance_color,
            fillOpacity: 0,
            shape: "circle",
            radius: 11
        }).addTo(betweenPointsGroup);
        betweenPointsGroup.addTo(distance);

        points = points.filter(
            item => (
                (item[0] != pointCurrent[0]) && (item[1] != pointCurrent[1])
            )
        );

        // Plotando distancias
        points.forEach(element => {

            let polyline = L.polyline([element, pointCurrent], {
                color: line_distance_color,
                weight: 1
            }).addTo(betweenPointsGroup);
            betweenPointsGroup.addTo(distance);

            var point1 = turf.point(pointCurrent);
            var point2 = turf.point(element);
            var midpoint = turf.midpoint(point1, point2);

            var from = turf.point(pointCurrent);
            var to = turf.point(element);
            var distancePolyline = turf.distance(from, to);

            var popupMap = L.popup()
                .setLatLng(midpoint.geometry.coordinates)
                .setContent(distancePolyline.toFixed(2) + ' KM')
                .addTo(betweenPointsGroup);
            betweenPointsGroup.addTo(distance);
        });
    }

    async function plotDistance(pedaladas, distance) {

        let points = [];
        pedaladas.forEach(element => {
            points.push(element.pointInitial);
        });

        const promisesPoints = pedaladas.map(async (pedalada_current, idx) => {

            L.shapeMarker(pedalada_current.pointInitial, {
                    color: pedalada_current.color_selected,
                    fillColor: pedalada_current.color_selected,
                    fillOpacity: 1,
                    shape: "circle",
                    radius: 6
                }).addTo(distance)
                .on(
                    'click',
                    async function(event) {
                        plotDistanceBetweenPoints(
                            event, distance, points
                        );
                    });
        });

        await Promise.all(promisesPoints);

        return distance;

    }

    async function convertToObjectLatLng(points) {

        latlng = [];

        points.forEach(element => {
            latlng.push(L.latLng(element));
        });

        return latlng;
    }


    async function updateMapChart() {

        console.log("Update MapChart ...");
        await resizeMapChart();

        if (betweenPointsGroup != null) {
            betweenPointsGroup.removeFrom(distance);
            betweenPointsGroup = null;
        }

        let route = L.featureGroup();
        let distance = L.featureGroup();
        let analysis = L.featureGroup();

        route = await plotLines(pedaladas_barChart, route);
        route = await plotMarkles(pedaladas_barChart, route);
        distance = await plotDistance(pedaladas_barChart, distance);
        //heatmap = await plotHeatmap(pedaladas_barChart, heatmap);
        let map = await defineLayer(route, distance, analysis, pedaladas_barChart);
        let centerMap = await calculateMapCenter(pedaladas_barChart);
    }
</script>