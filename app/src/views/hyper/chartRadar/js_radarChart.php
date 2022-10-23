<script>
    async function mountValues(pedalada) {

        let result = await getRecord(pedalada);
        // heartrate, elevation, distance, duration, speed
        return [
            parseFloat(result.heartrate.toFixed(2)),
            parseFloat(result.elevation_AVG.toFixed(2)),
            parseFloat((100 / 2).toFixed(2)),
            parseFloat(result.time_in_hours.toFixed(2)),
            parseFloat(result.speed.toFixed(2))
        ];
    }

    async function mountData(pedalada) {

        console.log("Montando data ...");
        return {

            label: pedalada.rider,
            data: await mountValues(pedalada),
            fill: false,
            borderColor: pedalada.color_selected,
            pointBackgroundColor: pedalada.color_selected,
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: pedalada.color_selected

        }
    }

    async function mountDataSetsRadarChart(pedaladas_barChart) {

        console.log("Montando dataset ...");
        let dataset = [];
        const promises = pedaladas_barChart.map(async (pedalada, idx) => {
            dataset.push(await mountData(pedalada));
        });

        await Promise.all(promises);

        return dataset;
    }


    function removeRadarChart() {

        d3.select('#pedaladas_radarChart').remove();
    }

    function calculateHeightRadarChart() {

        return parseInt(heightWindow / 2);
    }

    function createBoxRadarChart() {
        let heightRadarChart = calculateHeightRadarChart();
        d3.select('#radarChart')
            .append('canvas')
            .attr("id", 'pedaladas_radarChart')
            .attr("height", heightRadarChart + 'px');

    }

    async function create_RadarChart() {

        const ctx = document.getElementById('pedaladas_radarChart');
        const data = {
            labels: [
                'Avg Heartrate',
                'Avg Elevation',
                'Distance',
                'Duration',
                'Avg Speed',
            ],
            datasets: await mountDataSetsRadarChart(store.session.get('pedaladas_barChart'))
        };
        const myChart = new Chart(ctx, {
            type: 'radar',
            data,
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                elements: {
                    line: {
                        borderWidth: 3
                    }
                }
            },
        });
    }

    async function updateRadarChart() {

        console.group("RadarChart ...");
        console.log("Atualizando RadarChart ...");

        await removeRadarChart();
        await createBoxRadarChart();
        //$('#pedaladas_barChart_card').show();
        console.groupEnd();
        create_RadarChart().then(() => {
            totalStorage(); // Monitorando Storage
        });
    }
</script>