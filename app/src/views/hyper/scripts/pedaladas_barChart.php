<script>
    function mount_pedalada_barChart(pedalada) {

        return {
            'id': d3.select(pedalada).attr('id'),
            'distance': parseFloat(d3.select(pedalada).attr('distance')),
            'status': d3.select(pedalada).attr('pedalada_clicada')
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

    function update_barChart() {
        console.log('Atualizando bar chart');
        const ctx = document.getElementById('pedaladas_barChart');
        const labels = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
        const data = {
            labels: labels,
            datasets: [{
                barPercentage: 1.0,
                categoryPercentage: 1.0,
                axis: 'y',
                data: [16, 6, 15, 178, 68, 41, 127, 223, 17, 279, 32, 106, 73, 250, 63],
                fill: true,
                backgroundColor: [
                    'rgb(211, 69, 91)', 'rgb(116, 27, 40)', 'rgb(239, 189, 196)',
                    'rgb(44, 136, 217)', 'rgb(22, 75, 121)', 'rgb(186, 216, 242)',
                    'rgb(247, 195, 37)', 'rgb(138, 105, 5)', 'rgb(252, 233, 176)',
                    'rgb(47, 177, 156)', 'rgb(30, 113, 98)', 'rgb(191, 238, 229)',
                    'rgb(115, 15, 195)', 'rgb(78,10,133)', 'rgb(218, 179, 249)'
                ]
            }]
        };
        const myChart = new Chart(ctx, {
            type: 'bar',
            data,
            options: {
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (context.parsed.y !== null) {
                                    label += 'Distancia';
                                }
                                return label;
                            }
                        }


                    }
                }
            }
        });
    }
</script>