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

async function putMarkerHotline(point, icon, shape, color_selected, title, layer) {

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
        shape: shape,
        radius: 14
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
                    'circle',
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
                    'square',
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
                    'triangle',
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
    let intensity = pedalada.intensity_normalized;
    let map_point = pedalada.map_point;
    let index_map_point = 0;

    let hotlineData = [];
    const promises = points.map(async (point_current, idx) => {

        if (idx == 0) {
            point_current.push(Math.min(...intensity));
            hotlineData.push(point_current);
            index_map_point++;
        } else {

            if (map_point[index_map_point + 1] != undefined) {

                if ((idx < map_point[index_map_point + 1].index)) {
                    point_current.push(intensity[index_map_point]);
                    hotlineData.push(point_current);
                } else {
                    index_map_point++;
                }

            } else {
                point_current.push(intensity[index_map_point]);
                hotlineData.push(point_current);
            }
        }


    });

    await Promise.all(promises);

    return hotlineData

}

async function plotHotline(pedaladas, hotline) {

    const promises = pedaladas.map(async (pedalada_current, idx) => {

        let hotlineData = await mountHotlineData(pedalada_current);

        await L.hotline(hotlineData, {
            min: Math.min(...pedalada_current.intensity_normalized),
            max: Math.max(...pedalada_current.intensity_normalized),
            palette: {
                0.0: colorHeatmap[0],
                0.1: colorHeatmap[0],
                0.2: colorHeatmap[0],
                0.3: colorHeatmap[1],
                0.4: colorHeatmap[1],
                0.5: colorHeatmap[2],
                0.6: colorHeatmap[2],
                0.7: colorHeatmap[3],
                0.8: colorHeatmap[3],
                0.9: colorHeatmap[4],
                1.0: colorHeatmap[4],
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
        }).bindPopup(`<b>Final</b><br>
                Data e Hora: ${pedalada_current.datetime}<br>
                Lat,Lon: ${pedalada_current.pointInitial}<br>
                Freq. Cardíaca Média: ${pedalada_current.heartrate_AVG} bpm<br>
                Distância: ${pedalada_current.distance} KM<br>
                Velocidade Média: ${pedalada_current.speed_AVG} KM/H<br>
                Duração: ${pedalada_current.duration} <br>
                País: ${pedalada_current.country}<br>
                Localidade: ${pedalada_current.locality}
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
        }).bindPopup(`<b>Início</b><br>
                Data e Hora: ${pedalada_current.datetime}<br>
                Lat,Lon: ${pedalada_current.pointFinal}<br>
                Freq. Cardíaca Média: ${pedalada_current.heartrate_AVG} bpm<br>
                Distância ${pedalada_current.distance} KM<br>
                Velocidade Média ${pedalada_current.speed_AVG} KM/H<br>
                Duração: ${pedalada_current.duration} <br>
                País: ${pedalada_current.country}<br>
                Localidade: ${pedalada_current.locality}
                `).addTo(hotline);

    });

    await Promise.all(promises);

    return hotline;
}
</script>