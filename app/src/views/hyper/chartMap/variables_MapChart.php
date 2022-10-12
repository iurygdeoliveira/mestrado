<script>
    async function createDB(rider) {

        Dexie.exists(rider).then(function(exists) {
            if (!exists) {
                console.log("Gerando estrutura de cache para o " + rider);
                var db = new Dexie(rider);
                db.version(1).stores({
                    coordinates: '++id,rider,distance,pedaladaID,pointInicial,pointFinal,points,centroid,elevation,elevation_percentage'
                });
                db.open();
            }
        });
    }

    // *********************************************
    // Constantes utilizadas em pedaladas_mapChart
    // *********************************************
    store.session.set('pedaladas_coordinates', []);
    let pedaladas_mapChart = [];

    for (let index = 1; index <= 19; index++) {
        createDB('rider' + index);
    }

    let layerMap = 'http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png';
</script>