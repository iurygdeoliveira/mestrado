<script>
    async function extractPedalada(arr, value) {

        let result = arr.filter(function(ele) {
            return ele.id === value;
        });
        return result[0];
    }

    async function extractMapPoint(arr, value) {

        let result = arr.filter(function(ele) {
            return ele.axis === value;
        });
        return result[0];
    }

    async function putMarkerHotline(point, icon, color_selected, title, layer) {

        L.marker(point, {
            icon: L.BeautifyIcon.icon({
                icon: icon,
                iconShape: 'marker',
                backgroundColor: color_selected,
                borderColor: color_selected,
                textColor: 'white'
            }),
            draggable: true
        }).bindPopup(title).addTo(layer);

        L.shapeMarker(point, {
            color: color_selected,
            fillColor: color_selected,
            fillOpacity: 0.2,
            shape: "circle",
            radius: 12
        }).addTo(layer);

    }
    async function plotMarkerHotline(params, scale) {

        if (scale == 'bpm') {
            hotline.removeLayer(markerHotlineHeartrate);
            markerHotlineHeartrate = L.featureGroup();
        }

        if (scale == 'KM/H') {
            hotline.removeLayer(markerHotlineSpeed);
            markerHotlineSpeed = L.featureGroup();
        }

        if (scale == 'meters') {
            hotline.removeLayer(markerHotlineElevation);
            markerHotlineElevation = L.featureGroup();
        }

        for (const iterator of params) {


            if (scale == 'bpm') {

                let pedalada = await extractPedalada(pedaladas_barChart, iterator.name);
                let mapPoint = await extractMapPoint(pedalada.map_point, iterator.axisValue);

                if (mapPoint != undefined) {
                    await putMarkerHotline(
                        pedalada.points[mapPoint.index],
                        'fa-solid fa-h',
                        pedalada.color_selected,
                        "Heartrate",
                        markerHotlineHeartrate
                    );
                }

            }

            if (scale == 'KM/H') {

                let pedalada = await extractPedalada(pedaladas_barChart, iterator.name);
                let mapPoint = await extractMapPoint(pedalada.map_point, iterator.axisValue);

                if (mapPoint != undefined) {
                    await putMarkerHotline(
                        pedalada.points[mapPoint.index],
                        'fa-solid fa-s',
                        pedalada.color_selected,
                        "Speed",
                        markerHotlineSpeed
                    );
                }

            }

            if (scale == 'meters') {

                let pedalada = await extractPedalada(pedaladas_barChart, iterator.seriesName);
                let mapPoint = await extractMapPoint(pedalada.map_point, parseInt(iterator.axisValue));

                if (mapPoint != undefined) {
                    await putMarkerHotline(
                        pedalada.points[mapPoint.index],
                        'fa-solid fa-e',
                        pedalada.color_selected,
                        "Elevation",
                        markerHotlineElevation
                    );
                }
            }
        }

        if (scale == 'bpm') {
            markerHotlineHeartrate.addTo(hotline);
        }

        if (scale == 'KM/H') {
            markerHotlineSpeed.addTo(hotline);
        }

        if (scale == 'meters') {
            markerHotlineElevation.addTo(hotline);
        }

    }

    async function mountHotlineData(pedalada) {

        let points = pedalada.points;
        let heartrate = pedalada.heartrate_history;

        let hotlineData = [];
        const promises = points.map(async (point_current, idx) => {
            point_current.push(heartrate[idx]);
            hotlineData.push(point_current);
        });

        await Promise.all(promises);

        return hotlineData

    }

    async function plotHotline(pedaladas, hotline) {

        const promises = pedaladas.map(async (pedalada_current, idx) => {

            let hotlineData = await mountHotlineData(pedalada_current);

            await L.hotline(hotlineData, {
                min: Math.min(...pedalada_current.heartrate_history),
                max: Math.max(...pedalada_current.heartrate_history),
                palette: {
                    0.0: hotlinePalette[0],
                    0.5: hotlinePalette[1],
                    1.0: hotlinePalette[2]
                },
                weight: 5,
                outlineColor: '#000',
                outlineWidth: 2
            }).addTo(hotline);

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
                `).addTo(hotline);


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
                `).addTo(hotline);

        });

        await Promise.all(promises);

        return hotline;
    }

    // Escreva uma função utilizando php que  realize o cálculo da formula de haversine 
</script>