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

    async function defineLayer(centerMap, zoom) {

        map = L.map('pedaladas_mapChart');
        var tiles = L.tileLayer(layerMap, {
            minZoom: minZoom,
            maxZoom: maxZoom,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        map.on('click', onMapClick);
        return map;


    }

    async function plotLines(pedaladas_barChart, map) {

        console.log("Plotando linestring ...");

        let polyline;
        const promises = pedaladas_barChart.map(async (pedalada_current, idx) => {
            let result = await getRecord(pedalada_current);
            polyline = L.polyline(result.points, {
                color: pedalada_current.color_selected
            }).addTo(map);
        });

        await Promise.all(promises);

        return polyline;

    }


    async function plotMarkles(pedaladas_barChart, map) {

        console.log("Plotando Circles ...");

        let polyline;
        const promises = pedaladas_barChart.map(async (pedalada_current, idx) => {
            let result = await getRecord(pedalada_current);

            if (result.country == '') {
                result.country == 'not found'
            }

            if (result.locality == '') {
                result.locality == 'not found'
            }

            L.circle(result.pointInitial, {
                    color: pedalada_current.color_selected,
                    fillColor: pedalada_current.color_selected,
                    fillOpacity: 0.5,
                    radius: 100
                })
                .bindPopup(
                    `<b>Start</b><br>
                    Datetime: ${result.datetime}<br>
                    Lat,Lon: ${result.pointInitial}<br>
                    Avg Heartrate: ${result.heartrate} bpm<br>
                    Distance: ${result.distance} KM<br>
                    Avg Speed: ${result.speed} KM/H<br>
                    Time: ${result.time} <br>
                    Country: ${result.country}<br>
                    Locality: ${result.locality}
                    `
                ).addTo(map);


            L.circle(result.pointFinal, {
                color: pedalada_current.color_selected,
                fillColor: pedalada_current.color_selected,
                fillOpacity: 0.5,
                radius: 100
            }).bindPopup(
                `<b>Finish</b><br>
                Datetime: ${result.datetime}<br>
                Lat,Lon: ${result.pointFinal}<br>
                Avg Heartrate: ${result.heartrate} bpm<br>
                Distance: ${result.distance} KM<br>
                Avg Speed: ${result.speed} KM/H<br>
                Time: ${result.time} <br>
                Country: ${result.country}<br>
                Locality: ${result.locality}
                `
            ).addTo(map);

        });

        await Promise.all(promises);

        return map;

    }

    async function updateMapChart() {

        console.group("MapChart ...");
        console.log("Atualizando MapChart ...");

        resizeMapChart();
        let map = await defineLayer([0, 0], initialZoom);
        let polyline = await plotLines(store.session.get('pedaladas_barChart'), map);
        map = await plotMarkles(store.session.get('pedaladas_barChart'), map);
        let centerMap = await calculateMapCenter(store.session.get('pedaladas_barChart'));
        console.groupEnd();

    }
</script>