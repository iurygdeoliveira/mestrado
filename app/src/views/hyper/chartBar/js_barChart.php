<script>
    function has_pedaladas_barChart() {

        if (store.session.get('pedaladas_barChart').length > 0) {
            return true;
        } else {
            return false;
        }

    }

    function mount_pedalada_barChart(pedalada) {

        return {
            'id': d3.select(pedalada).attr('id'),
            'rider': d3.select(pedalada).attr('rider'),
            'line_clicked': d3.select(pedalada).attr('line_clicked'),
            'color_selected': d3.select(pedalada).attr('color_selected'),
            'distance': parseFloat(d3.select(pedalada).attr('distance')),
            'style': d3.select(pedalada).attr('style')
        };
    }

    function push_pedaladas_barChart(pedalada) {

        let pedalada_barChart = mount_pedalada_barChart(pedalada);
        store.session.add('pedaladas_barChart', pedalada_barChart);

        updateButtonSearchRiders(selected, false, true, false);
        storePedalada(pedalada_barChart).then((res) => {
            console.log('Primary Key: ', res);
            updateButtonSearchRiders(selected, true, false, false)
            update_barChart();
        });

    }

    function remove_pedaladas_barChart(pedalada) {

        let pedalada_barChart = mount_pedalada_barChart(pedalada);
        let pedaladas_barChart = store.session.get('pedaladas_barChart');
        pedaladas_barChart = pedaladas_barChart.filter(item => item.id !== pedalada_barChart.id)
        store.session.set('pedaladas_barChart', pedaladas_barChart);
        update_barChart();

    }

    function calculateHeightBarChart() {

        let heightChooseCyclist = $('#choose_cyclist').height();
        let heightSlider = $('#slider').height();
        return parseInt(heightWindow - heightChooseCyclist - heightSlider);
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

    function updateCacheBarChart(rider) {

        let pedaladas_barChart = store.session.get('pedaladas_barChart');

        if (pedaladas_barChart.length > 0) {

            //console.log("pedaladas barchart", pedaladas_barChart);
            pedaladas_barChart = pedaladas_barChart.filter(item => item.rider !== rider)
            store.session.set('pedaladas_barChart', pedaladas_barChart);
            console.log(pedaladas_barChart);
            update_barChart();
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

    async function update_barChart() {

        console.group("BarChart ...");
        console.log("Atualizando BarChart ...");
        removeBarChart();
        createBoxBarChart();
        $('#pedaladas_barChart_card').show();
        console.groupEnd();
        create_BarChart().then(async () => {
            await updateMapChart();
            // await updateRadarChart();
        });
    }
</script>