<script>
    async function resizeMapChart() {
        let heightMapChart = parseInt(heightWindow / 2);
        removeMapChart();
        d3.select('#mapChart').style('height', heightMapChart + 'px')
            .append('div')
            .attr("id", 'pedaladas_mapChart')
            .attr('class', 'p-0 m-0');
        controlRuler = null;
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

                if (controlRuler == null) {
                    addControlRuler(map);
                } else {
                    controlRuler._container.hidden = false;
                }
            }

            if (element.trim() == 'Route') {
                route.addTo(map);
                distance.removeFrom(map)
                controlRuler._container.hidden = true;
            }

        });
    }

    function addControlRuler(map) {

        var options = {
            position: 'topright', // Leaflet control position option
            circleMarker: { // Leaflet circle marker options for points used in this plugin
                color: line_distance_color,
                radius: 2
            },
            lineStyle: { // Leaflet polyline options for lines used in this plugin
                color: line_distance_color,
                dashArray: '1,6'
            },
            lengthUnit: { // You can use custom length units. Default unit is kilometers.
                display: 'km', // This is the display value will be shown on the screen. Example: 'meters'
                decimal: 2, // Distance result will be fixed to this value. 
                factor: null, // This value will be used to convert from kilometers. Example: 1000 (from kilometers to meters)  
                label: 'Distance:'
            },
            angleUnit: {
                display: '&deg;', // This is the display value will be shown on the screen. Example: 'Gradian'
                decimal: 2, // Bearing result will be fixed to this value.
                factor: null, // This option is required to customize angle unit. Specify solid angle value for angle unit. Example: 400 (for gradian).
                label: 'Bearing:'
            }
        };

        controlRuler = L.control.ruler(options).addTo(map);

    }

    async function defineLayer(centerMap, zoom, route, distance) {


        var routeLayer = L.tileLayer(layerMap, {
            minZoom: minZoom,
            maxZoom: maxZoom,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });

        var distanceLayer = L.tileLayer(layerMap, {
            minZoom: minZoom,
            maxZoom: maxZoom,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });

        const baseLayers = {
            'Distance': distanceLayer,
            'Route': routeLayer
        };

        map = L.map('pedaladas_mapChart', {
            layers: [distanceLayer, routeLayer]
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
        });

        await Promise.all(promises);

        return route;

    }

    async function plotDistance(pedaladas_barChart, distance) {

        const promisesPoints = pedaladas_barChart.map(async (pedalada_current, idx) => {

            var square = L.shapeMarker(pedalada_current.pointInitial, {
                    color: pedalada_current.color_selected,
                    fillColor: pedalada_current.color_selected,
                    fillOpacity: 1,
                    shape: "circle",
                    radius: 10
                }).addTo(distance)
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
        });

        await Promise.all(promisesPoints);

        return distance;

    }

    async function updateMapChart() {

        console.group("MapChart ...");
        console.log("Atualizando MapChart ...");
        resizeMapChart();
        // Construindo camada route
        let route = L.featureGroup();
        let distance = L.featureGroup();
        route = await plotLines(store.session.get('pedaladas_barChart'), route);
        route = await plotMarkles(store.session.get('pedaladas_barChart'), route);
        distance = await plotDistance(store.session.get('pedaladas_barChart'), distance);
        let map = await defineLayer([0, 0], initialZoom, route, distance);
        let centerMap = await calculateMapCenter(store.session.get('pedaladas_barChart'));
        console.groupEnd();
        totalStorage(); // Monitorando Storage
    }
</script>