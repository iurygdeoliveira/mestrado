<script>
    function mount_pedalada_barChart(pedalada) {

        let rider = d3.select(pedalada).attr('id').split("_");
        rider = rider[0].replace(/[^0-9]/g, '')

        return {
            'id': d3.select(pedalada).attr('id'),
            'rider': rider,
            'distance': parseFloat(d3.select(pedalada).attr('distance')),
            'status': d3.select(pedalada).attr('pedalada_clicada'),
            'color': d3.select(pedalada).attr('color_current')
        };
    }

    function push_pedaladas_barChart(pedalada) {

        let pedalada_barChart = mount_pedalada_barChart(pedalada);
        store.session.add('pedaladas_barChart', pedalada_barChart);
        //console.log(store.session.get('pedaladas_barChart'));

        update_barChart();
    }

    function remove_pedaladas_barChart(pedalada) {

        let pedalada_barChart = mount_pedalada_barChart(pedalada);
        let pedaladas_barChart = store.session.get('pedaladas_barChart');
        pedaladas_barChart = pedaladas_barChart.filter(item => item.id !== pedalada_barChart.id)
        store.session.set('pedaladas_barChart', pedaladas_barChart);
        update_barChart();

    }

    function removeBarChart() {

        d3.select('#pedaladas_barChart').remove();
        d3.select('#pedaladas_barChart_body')
            .append('canvas')
            .attr("id", 'pedaladas_barChart')
            .attr("width", '100%')
            .attr("height", '155');
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
            background.push(element.color);
        });

        return background;
    }

    function update_barChart() {

        console.log('Atualizando bar chart');

        // Atualizando tooltip button tablelens
        if (store.session.get('pedaladas_barChart').length > 0) {
            d3.select("#search_rides").attr("title", "See Table Lens");
        } else {
            d3.select("#search_rides").attr("title", "Generate Table Lens");
        }

        removeBarChart();

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
                indexAxis: 'x',
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
                                console.log(context.parsed);
                                if (context.parsed.y !== null) {
                                    let pedaladas_barChart_tooltip = store.session.get('pedaladas_barChart');
                                    let tooltip = pedaladas_barChart_tooltip.find(x => x.distance === context.parsed.y);
                                    label += tooltip.distance + ' KM';
                                }
                                return label;
                            }
                        }


                    }
                }
            }
        });

        totalStorage(); // Monitorando Storage
    }
</script>