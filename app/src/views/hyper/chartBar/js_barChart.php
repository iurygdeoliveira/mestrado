<script>
    function has_pedaladas_barChart() {

        if (pedaladas_barChart.length > 0) {
            return true;
        } else {
            return false;
        }

    }

    async function mount_pedalada_barChart(pedalada) {

        return {
            'centroid': null,
            'color_selected': d3.select(pedalada).attr('color_selected'),
            'country': null,
            'datetime': null,
            'distance': parseFloat(d3.select(pedalada).attr('distance')),
            'distance_history': null,
            'duration': null,
            'elevation_AVG': null,
            'elevation_history': null,
            'elevation_stream': null,
            'elevation_stream_max': null,
            'heartrate_AVG': null,
            'heartrate_history': null,
            'heartrate_stream': null,
            'heartrate_stream_max': null,
            'id': d3.select(pedalada).attr('id'),
            'line_clicked': d3.select(pedalada).attr('line_clicked'),
            'locality': null,
            'minute_history': null,
            'pedal_id': null,
            'pointInitial': null,
            'pointFinal': null,
            'points': null,
            'rider': d3.select(pedalada).attr('rider'),
            'speed_AVG': null,
            'speed_history': null,
            'speed_stream': null,
            'speed_stream_max': null,
            'style': d3.select(pedalada).attr('style'),
            'temperature_AVG': null,
            'time_history': null
        };

    }

    async function push_pedaladas_barChart(pedalada) {


        let push_barChart = await mount_pedalada_barChart(pedalada);

        updateButtonSearchRiders(selected, false, true, false);

        let res = await storePedalada(push_barChart);

        push_barChart.pointInitial = res[0].pointInitial;
        push_barChart.pointFinal = res[0].pointFinal;
        push_barChart.points = res[0].points;
        push_barChart.heartrate_AVG = res[0].heartrate_AVG;
        push_barChart.speed_AVG = res[0].speed_AVG;
        push_barChart.elevation_AVG = res[0].elevation_AVG;
        push_barChart.temperature_AVG = res[0].temperature_AVG;
        push_barChart.duration = res[0].duration;
        push_barChart.datetime = res[0].datetime;
        push_barChart.country = res[0].country;
        push_barChart.locality = res[0].locality;
        push_barChart.centroid = res[0].centroid;
        push_barChart.elevation_history = res[0].elevation_history;
        push_barChart.elevation_stream = res[0].elevation_stream;
        push_barChart.elevation_stream_max = res[0].elevation_stream_max;
        push_barChart.heartrate_history = res[0].heartrate_history;
        push_barChart.heartrate_stream = res[0].heartrate_stream;
        push_barChart.heartrate_stream_max = res[0].heartrate_stream_max;
        push_barChart.speed_stream = res[0].speed_stream;
        push_barChart.speed_stream_max = res[0].speed_stream_max;
        push_barChart.speed_history = res[0].speed_history;
        push_barChart.minute_history = res[0].minute_history;

        pedaladas_barChart.push(push_barChart);


        let sum = 0;
        let meter = 0;
        let position = [];
        position.push(0);
        let average = [];
        let idx1 = 0;
        let idx2 = 0;

        for (; idx2 < res[0].distance_history.length; idx2++) {

            sum += res[0].distance_history[idx2];
            meter = sum * 1000;

            if (meter >= 48) {
                average.push({
                    'distance': meter,
                    'idx1': idx1,
                    'idx2': idx2,
                });
                idx1 = idx2 + 1;
                sum = 0;
            }
        }

        console.log(average);
        updateButtonSearchRiders(selected, true, false, false)

        if (pedaladas_barChart.length > 0) {
            update_barChart(true);
        } else {
            update_barChart(false);
        }

    }

    async function remove_pedaladas_barChart(pedal) {

        let pedalada_current = await mount_pedalada_barChart(pedal);
        pedaladas_barChart = pedaladas_barChart.filter(item => item.id !== pedalada_current.id);
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

        let labels = [];
        pedaladas_barChart.forEach(element => {
            labels.push('');
        });

        return labels;
    }

    function mountDistances() {

        let distances = [];
        pedaladas_barChart.forEach(element => {
            distances.push(element.distance);
        });

        return distances;
    }

    function mountBackgroundColor() {

        let background = [];
        pedaladas_barChart.forEach(element => {
            background.push(element.color_selected);
        });

        return background;
    }

    function updateCacheBarChart(rider, buttonMultivis) {

        if (pedaladas_barChart.length > 0) {

            pedaladas_barChart = pedaladas_barChart.filter(item => item.rider !== rider)

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
                                    let pedaladas_barChart_tooltip = pedaladas_barChart;
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

        if (pedaladas_barChart.length > 0) {
            createBoxBarChart();
            $('#pedaladas_barChart_card').show();
            await create_BarChart();
        }
    }
</script>