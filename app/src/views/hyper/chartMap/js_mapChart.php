<script>
    async function resizeMapChart() {
        let heightMapChart = parseInt(heightWindow / 2);
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
            let result = await getRecord(pedalada_current);
            centroids.push(result.centroid);
        });

        await Promise.all(promises);

        console.log("Centroids", centroids);
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

    function onMapClick(e) {

        var popup = L.popup();

        popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at <br>" + e.latlng.toString())
            .openOn(map);
    }

    function changeView(route) {

        $("#pedaladas_mapChart").click(function(event) {

            //console.log(event);
            let element = new String(event.target.innerHTML);
            //console.log(element.trim());

            if (element.trim() == 'Distance') {
                route.removeFrom(map);
            }

            if (element.trim() == 'Route') {
                route.addTo(map);
            }

        });
    }

    async function defineLayer(centerMap, zoom, route) {


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

        changeView(route);

        map.on('click', onMapClick);
        return map;


    }

    async function plotLines(pedaladas_barChart, route) {

        let polyline;
        const promises = pedaladas_barChart.map(async (pedalada_current, idx) => {
            let result = await getRecord(pedalada_current);
            polyline = L.polyline(result.points, {
                color: pedalada_current.color_selected,
                dashArray: "15 15",
                dashSpeed: 30
            }).addTo(route);
        });

        await Promise.all(promises);

        return route;
    }


    async function plotMarkles(pedaladas_barChart, route) {

        const promises = pedaladas_barChart.map(async (pedalada_current, idx) => {
            let result = await getRecord(pedalada_current);

            var square = L.shapeMarker(result.pointInitial, {
                    color: pedalada_current.color_selected,
                    fillColor: pedalada_current.color_selected,
                    fillOpacity: 0.5,
                    shape: "square",
                    radius: 5
                }).addTo(route)
                .bindPopup(
                    `<b>Start</b><br>
                Datetime: ${result.datetime}<br>
                Lat,Lon: ${result.pointInitial}<br>
                Avg Heartrate: ${result.heartrate_AVG} bpm<br>
                Distance: ${result.distance} KM<br>
                Avg Speed: ${result.speed_AVG} KM/H<br>
                Duration: ${result.duration} <br>
                Country: ${result.country}<br>
                Locality: ${result.locality}
                `
                );

            var triangle = L.shapeMarker(result.pointFinal, {
                color: pedalada_current.color_selected,
                fillColor: pedalada_current.color_selected,
                fillOpacity: 0.5,
                shape: "triangle",
                radius: 5
            }).addTo(route).bindPopup(
                `<b>Start</b><br>
                Datetime: ${result.datetime}<br>
                Lat,Lon: ${result.pointInitial}<br>
                Avg Heartrate: ${result.heartrate_AVG} bpm<br>
                Distance: ${result.distance} KM<br>
                Avg Speed: ${result.speed_AVG} KM/H<br>
                Duration: ${result.duration} <br>
                Country: ${result.country}<br>
                Locality: ${result.locality}
                `
            );
        });

        await Promise.all(promises);

        return route;

    }

    async function updateMapChart() {

        console.group("MapChart ...");
        console.log("Atualizando MapChart ...");

        resizeMapChart();

        // Construindo camada route
        let route = L.featureGroup();
        route = await plotLines(store.session.get('pedaladas_barChart'), route);
        route = await plotMarkles(store.session.get('pedaladas_barChart'), route);
        let map = await defineLayer([0, 0], initialZoom, route);
        let centerMap = await calculateMapCenter(store.session.get('pedaladas_barChart'));
        console.groupEnd();

    }
</script>