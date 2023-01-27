<script>
    /**
     * CACHE DISTANCES
     */
    let distances = [];
    async function createDB(rider) {

        Dexie.exists(rider).then(function(exists) {
            if (!exists) {
                console.log("Gerando estrutura de cache para o " + rider);
                var db = new Dexie(rider);
                db.version(1).stores({
                    pedaladas: '++id,' +
                        'rider,' +
                        'pedal_id,' +
                        'datetime,' +
                        'country,' +
                        'locality,' +
                        'elevation_AVG,' +
                        'speed_AVG,' +
                        'temperature_AVG,' +
                        'heartrate_AVG,' +
                        'duration,' +
                        'distance,' +
                        'centroid,' +
                        'pointInitial,' +
                        'pointFinal,' +
                        'points,' +
                        'map_point,' +
                        'distance_history,' +
                        'elevation_history,' +
                        'elevation_intensity,' +
                        'elevation_stream,' +
                        'elevation_stream_max,' +
                        'elevation_stream_min,' +
                        'heartrate_history,' +
                        'heartrate_intensity,' +
                        'heartrate_stream,' +
                        'heartrate_stream_max,' +
                        'heartrate_stream_min,' +
                        'speed_history,' +
                        'speed_intensity,' +
                        'speed_stream,' +
                        'speed_stream_max,' +
                        'speed_stream_min,' +
                        'intensity,' +
                        'time_history'
                });
                db.open();
            }
        });
    }

    for (let index = 1; index <= 19; index++) {
        createDB('rider' + index);
    }
</script>