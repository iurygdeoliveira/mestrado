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

        console.log("Calculando map center ...");
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

        return L.tileLayer(layerMap, {
            minZoom: minZoom,
            maxZoom: maxZoom,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });

    }

    async function addLayerDistance(map, route, distance, heatmap) {

        var stateChangingButton = L.easyButton({
            states: [{
                stateName: 'see-distances', // name the state
                icon: 'mdi mdi-18px mdi-map-marker-distance', // and define its properties
                title: 'See distances', // like its title
                onClick: function(btn, map) { // and its callback
                    distance.addTo(map);
                    route.removeFrom(map);
                    heatmap.removeFrom(map);
                    btn.state('see-distances'); // change state on click!
                }
            }]
        });

        stateChangingButton.addTo(map);

    }

    async function addLayerRoute(map, route, distance, heatmap) {

        var stateChangingButton = L.easyButton({
            states: [{
                stateName: 'see-routes', // name the state
                icon: 'mdi mdi-18px mdi-map-marker-path', // and define its properties
                title: 'See Routes', // like its title
                onClick: function(btn, map) { // and its callback
                    route.addTo(map);
                    distance.removeFrom(map);
                    heatmap.removeFrom(map);
                    btn.state('see-routes'); // change state on click!
                }
            }]
        });

        stateChangingButton.addTo(map);
    }

    async function addLayerHeatmap(map, route, distance, heatmap) {

        var stateChangingButton = L.easyButton({
            states: [{
                stateName: 'see-heatmap', // name the state
                icon: 'mdi mdi-18px mdi-temperature-celsius', // and define its properties
                title: 'See Heatmap', // like its title
                onClick: function(btn, map) { // and its callback
                    heatmap.addTo(map);
                    distance.removeFrom(map);
                    route.removeFrom(map);
                    btn.state('see-heatmap'); // change state on click!
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

    async function defineLayer(route, distance, heatmap, pedaladas) {


        var routeLayer = mountTile();
        var distanceLayer = mountTile();
        var heatmapLayer = mountTile();

        const baseLayers = {
            'Distance': distanceLayer,
            'Route': routeLayer,
            'Heatmap': heatmapLayer
        };

        map = L.map('pedaladas_mapChart', {
            fullscreenControl: true,
            layers: [distanceLayer, routeLayer, heatmapLayer]
        });

        heatmap.addTo(map);
        await addLayerHeatmap(map, route, distance, heatmap);
        await addLayerRoute(map, route, distance, heatmap);
        await addLayerDistance(map, route, distance, heatmap);
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

    async function plotHeatmap(pedaladas, heatmap) {

        let heat;
        const promisesPoints = pedaladas.map(async (pedalada_current, idx) => {

            heat = L.heatLayer(await convertToObjectLatLng(pedalada_current.points));

            heat.addTo(heatmap);
        });

        await Promise.all(promisesPoints);

        return heatmap;
    }

    async function updateMapChart() {

        console.group("MapChart ...");
        console.log("Atualizando MapChart ...");
        await resizeMapChart();

        if (betweenPointsGroup != null) {
            betweenPointsGroup.removeFrom(distance);
            betweenPointsGroup = null;
        }

        let route = L.featureGroup();
        let distance = L.featureGroup();
        let heatmap = L.featureGroup();

        route = await plotLines(pedaladas_barChart, route);
        route = await plotMarkles(pedaladas_barChart, route);
        distance = await plotDistance(pedaladas_barChart, distance);
        heatmap = await plotHeatmap(pedaladas_barChart, heatmap);
        let map = await defineLayer(route, distance, heatmap, pedaladas_barChart);
        let centerMap = await calculateMapCenter(pedaladas_barChart);

        console.groupEnd();
    }
</script>