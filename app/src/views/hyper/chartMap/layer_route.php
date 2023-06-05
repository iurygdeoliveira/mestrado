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
        }).bindPopup(`<b>Final</b><br>
                Data e Hora: ${pedalada_current.datetime}<br>
                Lat,Lon: ${pedalada_current.pointInitial}<br>
                Freq. Cardíaca Média: ${pedalada_current.heartrate_AVG} bpm<br>
                Distância: ${pedalada_current.distance} KM<br>
                Veloc. Média: ${pedalada_current.speed_AVG} KM/H<br>
                Duração: ${pedalada_current.duration} <br>
                País: ${pedalada_current.country}<br>
                Localidade: ${pedalada_current.locality}
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
        }).bindPopup(`<b>Início</b><br>
                Data e Hora: ${pedalada_current.datetime}<br>
                Lat,Lon: ${pedalada_current.pointFinal}<br>
                Freq. Cardíaca Média: ${pedalada_current.heartrate_AVG} bpm<br>
                Distância: ${pedalada_current.distance} KM<br>
                Veloc. Média: ${pedalada_current.speed_AVG} KM/H<br>
                Duração: ${pedalada_current.duration} <br>
                País: ${pedalada_current.country}<br>
                Localidade: ${pedalada_current.locality}
                `).addTo(route);

    });

    await Promise.all(promises);

    return route;

}
</script>