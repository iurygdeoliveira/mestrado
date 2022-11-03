<script>
    // *********************************************
    // Constantes utilizadas em pedaladas_mapChart
    // *********************************************

    //let layerMap = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
    //http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png
    let layerMap = 'http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png';
    let initialZoom = 5;
    let minZoom = 0;
    let maxZoom = 20;
    let map = false;
    const line_distance_color = 'rgb(50,50,50)';
    let betweenPointsGroup = null;
</script>