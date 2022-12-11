<script>
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
</script>