<script>
    function has_pedaladas_barChart() {

        if (store.session.get('pedaladas_barChart').length > 0) {
            return true;
        } else {
            return false;
        }

    }

    async function mount_pedalada_barChart(pedalada) {

        return {
            'id': d3.select(pedalada).attr('id'),
            'rider': d3.select(pedalada).attr('rider'),
            'line_clicked': d3.select(pedalada).attr('line_clicked'),
            'color_selected': d3.select(pedalada).attr('color_selected'),
            'style': d3.select(pedalada).attr('style'),
            'distance': parseFloat(d3.select(pedalada).attr('distance')),
            'pointInitial': null,
            'pointFinal': null,
            'points': null,
            'datetime': null,
            'heartrate_AVG': null,
            'speed_AVG': null,
            'duration': null,
            'country': null,
            'centroid': null

        };
    }

    async function push_pedaladas_barChart(pedalada) {


        let pedalada_barChart = await mount_pedalada_barChart(pedalada);

        updateButtonSearchRiders(selected, false, true, false);


        let res = await storePedalada(pedalada_barChart);

        pedalada_barChart.pointInitial = res[0].pointInitial;
        pedalada_barChart.pointFinal = res[0].pointFinal;
        pedalada_barChart.points = res[0].points;
        pedalada_barChart.heartrate_AVG = res[0].heartrate_AVG;
        pedalada_barChart.speed_AVG = res[0].speed_AVG;
        pedalada_barChart.elevation_AVG = res[0].elevation_AVG;
        pedalada_barChart.temperature_AVG = res[0].temperature_AVG;
        pedalada_barChart.duration = res[0].duration;
        pedalada_barChart.datetime = res[0].datetime;
        pedalada_barChart.country = res[0].country;
        pedalada_barChart.locality = res[0].locality;
        pedalada_barChart.centroid = res[0].centroid;
        store.session.add('pedaladas_barChart', pedalada_barChart);
        updateButtonSearchRiders(selected, true, false, false)

        if (store.session.get('pedaladas_barChart').length > 0) {
            update_barChart(true);
        } else {
            update_barChart(false);
        }

    }

    async function remove_pedaladas_barChart(pedal) {

        let pedalada_current = await mount_pedalada_barChart(pedal);
        let pedaladas = store.session.get('pedaladas_barChart');
        pedaladas = pedaladas.filter(item => item.id !== pedalada_current.id)
        store.session.set('pedaladas_barChart', pedaladas);
        update_barChart(true);

    }

    function calculateHeightBarChart() {

        let heightChooseCyclist = $('#choose_cyclist').height();
        let heightSlider = $('#slider').height();
        let heightMultiVis = $('#buttonMultivis').height();
        return parseInt(heightWindow - heightChooseCyclist - heightSlider - heightMultiVis);
    }

    function removeBarChart() {

        $('#pedaladas_barChart_card').hide();
        d3.select('#pedaladas_barChart').remove();

    }

    function createBoxBarChart() {
        let heightBarChart = calculateHeightBarChart() - adjustHeightBarChar;
        d3.select('#pedaladas_barChart_body')
            .append('canvas')
            .attr("id", 'pedaladas_barChart')
            .attr("height", heightBarChart + 'px');

    }

    function mountLabels() {

        let pedaladas_barChart = store.session.get('pedaladas_barChart');
        let labels = [];
        pedaladas_barChart.forEach(element => {
            labels.push('');
        });

        return labels;
    }

    function mountDistances() {

        let pedaladas_barChart = store.session.get('pedaladas_barChart');
        let distances = [];
        pedaladas_barChart.forEach(element => {
            distances.push(element.distance);
        });

        return distances;
    }

    function mountBackgroundColor() {

        let pedaladas_barChart = store.session.get('pedaladas_barChart');
        let background = [];
        pedaladas_barChart.forEach(element => {
            background.push(element.color_selected);
        });

        return background;
    }

    function updateCacheBarChart(rider, buttonMultivis) {

        let pedaladas_barChart = store.session.get('pedaladas_barChart');

        if (pedaladas_barChart.length > 0) {

            //console.log("pedaladas barchart", pedaladas_barChart);
            pedaladas_barChart = pedaladas_barChart.filter(item => item.rider !== rider)
            store.session.set('pedaladas_barChart', pedaladas_barChart);
            console.log(pedaladas_barChart);
            update_barChart(buttonMultivis);
        }
    }

    async function create_BarChart() {
        const ctx = document.getElementById('pedaladas_barChart');
        const data = {
            labels: mountLabels(),
            datasets: [{
                barPercentage: 1.0,
                categoryPercentage: 1.0,
                axis: 'y',
                data: mountDistances(),
                fill: true,
                backgroundColor: mountBackgroundColor()
            }]
        };
        const myChart = new Chart(ctx, {
            type: 'bar',
            data,
            options: {
                maintainAspectRatio: false,
                indexAxis: 'x',
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        displayColors: false,
                        position: 'average',
                        xAlign: 'center',
                        yAlign: 'bottom',
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (context.parsed.y !== null) {
                                    let pedaladas_barChart_tooltip = store.session.get('pedaladas_barChart');
                                    let tooltip = pedaladas_barChart_tooltip.find(x => x.distance === context.parsed.y);
                                    label += tooltip.distance.toFixed(2) + ' KM';
                                }
                                return label;
                            }
                        }


                    }
                }
            }
        });
    }

    async function update_barChart(buttonMultivis = false) {

        console.group("BarChart ...");
        console.log("Atualizando BarChart ...");
        removeBarChart();
        console.groupEnd();

        updateButtonMultivis(buttonMultivis);

        if (store.session.get('pedaladas_barChart').length > 0) {
            createBoxBarChart();
            $('#pedaladas_barChart_card').show();
            await create_BarChart();
        }
    }
</script>