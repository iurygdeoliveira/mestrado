<script>
    // *********************************************
    // Constantes utilizadas em pedaladas_mapChart
    // *********************************************

    let initialZoom = 5;
    let minZoom = 0;
    let maxZoom = 18;
    let map = false;
    const line_distance_color = 'rgb(50,50,50)';
    let betweenPointsGroup = null;
    let hotlinePalette = ['#55dde0', '#C8E04A', '#f26419']
    let route = L.featureGroup();
    let distanceMap = L.featureGroup();
    let hotline = L.featureGroup();
    let markerHotlineHeartrate = L.featureGroup();
    let markerHotlineSpeed = L.featureGroup();
    let markerHotlineElevation = L.featureGroup();
</script>