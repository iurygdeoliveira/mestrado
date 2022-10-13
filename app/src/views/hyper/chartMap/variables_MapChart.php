<script>
    async function createDB(rider) {

        Dexie.exists(rider).then(function(exists) {
            if (!exists) {
                console.log("Gerando estrutura de cache para o " + rider);
                var db = new Dexie(rider);
                db.version(1).stores({
                    coordinates: '++id,' +
                        'datetime,' +
                        'rider,' +
                        'distance,' +
                        'pedaladaID,' +
                        'pointInicial,' +
                        'pointFinal,' +
                        'points,' +
                        'centroid,' +
                        'elevation,' +
                        'elevation_percentage,' +
                        'address,' +
                        'time,' +
                        'speed,' +
                        'heartrate'
                });
                db.open();
            }
        });
    }

    // *********************************************
    // Constantes utilizadas em pedaladas_mapChart
    // *********************************************
    let pedaladas_mapChart = [];

    for (let index = 1; index <= 19; index++) {
        createDB('rider' + index);
    }

    let layerMap = 'http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png';
    let initialZoom = 5;
    let minZoom = 0;
    let maxZoom = 20;
    let map = false;
    let defineMapFlag = false;
</script>