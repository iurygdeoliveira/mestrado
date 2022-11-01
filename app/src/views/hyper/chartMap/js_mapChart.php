<script>
    async function resizeMapChart() {
        let heightMapChart = parseInt(heightWindow / 2) - adjustHeightCharts;
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
        let bounds;

        const promises = pedaladas_barChart.map(async (pedalada_current, idx) => {
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

    async function changeView(route, distance, map) {

        $("#pedaladas_mapChart").click(function(event) {

            //console.log(event);
            let element = new String(event.target.innerHTML);
            //console.log(element.trim());

            if (element.trim() == 'Distance') {
                distance.addTo(map);
                route.removeFrom(map);
            }

            if (element.trim() == 'Route') {
                route.addTo(map);
                distance.removeFrom(map);
            }

        });
    }

    function mountTile() {

        return L.tileLayer(layerMap, {
            minZoom: minZoom,
            maxZoom: maxZoom,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });

    }

    async function defineLayer(centerMap, zoom, route, distance, heatmap) {


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

        var layerControl = L.control.layers(baseLayers, null).addTo(map);
        route.addTo(map);

        await changeView(route, distance, map);

        return map;



    }

    async function plotLines(pedaladas_barChart, route) {

        let polyline;
        const promises = pedaladas_barChart.map(async (pedalada_current, idx) => {
            polyline = L.polyline(pedalada_current.points, {
                color: pedalada_current.color_selected,
                dashArray: "10 10",
                dashSpeed: 35
            }).addTo(route);
        });

        await Promise.all(promises);

        return route;
    }


    async function plotMarkles(pedaladas_barChart, route) {

        const promises = pedaladas_barChart.map(async (pedalada_current, idx) => {

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

        pointCurrent.push(event.latlng.lat);
        pointCurrent.push(event.latlng.lng);

        points = points.filter(
            item => (
                (item[0] != pointCurrent[0]) && (item[1] != pointCurrent[1])
            )
        );

        betweenPoints = L.featureGroup();

        points.forEach(element => {
            let polyline = L.polyline([element, pointCurrent], {
                color: line_distance_color,
                weight: 1,
                position: 'auto'
            });

            var point1 = turf.point(pointCurrent);
            var point2 = turf.point(element);
            var midpoint = turf.midpoint(point1, point2);

            var from = turf.point(pointCurrent);
            var to = turf.point(element);

            var distancePolyline = turf.distance(from, to);

            var tooltip = L.tooltip()
                .setLatLng(midpoint.geometry.coordinates)
                .setContent(distancePolyline.toFixed(2) + ' KM')
                .addTo(betweenPoints);

            polyline.addTo(betweenPoints);
        });

        betweenPoints.addTo(distance);

    }

    async function plotDistance(pedaladas_barChart, distance) {

        let points = [];
        pedaladas_barChart.forEach(element => {
            points.push(element.pointInitial);
        });

        const promisesPoints = pedaladas_barChart.map(async (pedalada_current, idx) => {

            var square = L.shapeMarker(pedalada_current.pointInitial, {
                    color: pedalada_current.color_selected,
                    fillColor: pedalada_current.color_selected,
                    fillOpacity: 1,
                    shape: "circle",
                    radius: 5
                }).addTo(distance)
                .on(
                    'mouseover',
                    async function(event) {
                        plotDistanceBetweenPoints(
                            event, distance, points
                        );
                    })
                .on('mouseout', function(event) {
                    betweenPoints.removeFrom(distance);
                });
        });

        await Promise.all(promisesPoints);

        return distance;

    }

    async function updateMapChart() {

        console.group("MapChart ...");
        console.log("Atualizando MapChart ...");
        resizeMapChart();

        let pedaladas = store.session.get('pedaladas_barChart');
        let route = L.featureGroup();
        let distance = L.featureGroup();
        let heatmap = L.featureGroup();
        route = await plotLines(pedaladas, route);
        route = await plotMarkles(pedaladas, route);
        distance = await plotDistance(pedaladas, distance);
        let map = await defineLayer([0, 0], initialZoom, route, distance, heatmap);
        let centerMap = await calculateMapCenter(pedaladas);
        console.groupEnd();
    }
</script>