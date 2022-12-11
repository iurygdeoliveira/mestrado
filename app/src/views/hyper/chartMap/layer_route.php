<script>
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


            L.marker(pedalada_current.pointInitial, {
                icon: L.BeautifyIcon.icon({
                    icon: 'fa-solid fa-flag-checkered',
                    iconShape: 'marker',
                    backgroundColor: pedalada_current.color_selected,
                    borderColor: pedalada_current.color_selected,
                    textColor: 'white'
                }),
                draggable: true
            }).bindPopup(`<b>Finish</b><br>
                Datetime: ${pedalada_current.datetime}<br>
                Lat,Lon: ${pedalada_current.pointInitial}<br>
                Avg Heartrate: ${pedalada_current.heartrate_AVG} bpm<br>
                Distance: ${pedalada_current.distance} KM<br>
                Avg Speed: ${pedalada_current.speed_AVG} KM/H<br>
                Duration: ${pedalada_current.duration} <br>
                Country: ${pedalada_current.country}<br>
                Locality: ${pedalada_current.locality}
                `).addTo(route);


            L.marker(pedalada_current.pointFinal, {
                icon: L.BeautifyIcon.icon({
                    icon: 'fa-solid fa-person-biking',
                    iconShape: 'marker',
                    backgroundColor: pedalada_current.color_selected,
                    borderColor: pedalada_current.color_selected,
                    textColor: 'white'
                }),
                draggable: true
            }).bindPopup(`<b>Start</b><br>
                Datetime: ${pedalada_current.datetime}<br>
                Lat,Lon: ${pedalada_current.pointFinal}<br>
                Avg Heartrate: ${pedalada_current.heartrate_AVG} bpm<br>
                Distance: ${pedalada_current.distance} KM<br>
                Avg Speed: ${pedalada_current.speed_AVG} KM/H<br>
                Duration: ${pedalada_current.duration} <br>
                Country: ${pedalada_current.country}<br>
                Locality: ${pedalada_current.locality}
                `).addTo(route);

        });

        await Promise.all(promises);

        return route;

    }
</script>