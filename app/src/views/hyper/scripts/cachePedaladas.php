<script>
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
                        'distance_history,' +
                        'elevation_history,' +
                        'heartrate_history,' +
                        'speed_history,' +
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