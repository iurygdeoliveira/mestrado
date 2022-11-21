<script>
    function has_pedaladas_barChart() {

        if (pedaladas_barChart.length > 0) {
            return true;
        } else {
            return false;
        }

    }

    async function prepare_pedalada_barChart(pedalada) {

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

    async function mount_pedalada_barChart(push_barChart, res) {

        push_barChart.pointInitial = res[0].pointInitial;
        push_barChart.pointFinal = res[0].pointFinal;
        push_barChart.points = res[0].points;
        push_barChart.heartrate_AVG = res[0].heartrate_AVG;
        push_barChart.speed_AVG = res[0].speed_AVG;
        push_barChart.elevation_AVG = res[0].elevation_AVG;
        push_barChart.temperature_AVG = res[0].temperature_AVG;
        push_barChart.duration = res[0].duration;
        push_barChart.distance_history = res[0].distance_history;
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
        push_barChart.time_history = res[0].time_history;

        return push_barChart;
    }

    async function push_pedaladas_barChart(pedalada) {

        let push_barChart = await prepare_pedalada_barChart(pedalada);
        updateButtonSearchRiders(selected, false, true, false);
        let res = await storePedalada(push_barChart);
        push_barChart = await mount_pedalada_barChart(push_barChart, res);
        pedaladas_barChart.push(push_barChart);
        updateButtonSearchRiders(selected, true, false, false)
        updateButtonMultivis(pedaladas_barChart, false, false, true);

    }

    async function remove_pedaladas_barChart(pedal) {

        pedaladas_barChart = pedaladas_barChart.filter(item => item.id !== pedal.id);
        updateButtonMultivis(pedaladas_barChart, false, false, true);

    }

    async function calculateHeightBarChart() {

        let heightChooseCyclist = $('#choose_cyclist').height();
        let heightSlider = $('#slider').height();
        let heightMultiVis = $('#buttonLoadingMultivis').height();
        return parseInt(heightWindow - heightChooseCyclist - heightSlider - heightMultiVis);
    }

    async function removeBarChart() {

        $('#pedaladas_barChart_card').hide();
        d3.select('#pedaladas_barChart').remove();

    }

    async function createBoxBarChart() {
        let heightBarChart = await calculateHeightBarChart() - adjustHeightBarChar;
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

        let distances_current = [];
        pedaladas_barChart.forEach(element => {
            distances_current.push(element.distance);
        });

        return distances_current;
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
            updateButtonMultivis(pedaladas_barChart, false, false, true);
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
                    title: {
                        display: true,
                        text: 'Distances',
                        position: 'top',
                        align: 'center'
                    },
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


    async function sortBarChart() {

        let pedaladasGrouped = [];
        // Ordenando pedaladas
        for (let count = 0; count < selected.length; count++) {
            pedaladasGrouped.push(pedaladas_barChart.filter(item => item.rider == selected[count]));
        }

        let pedalSort = [];
        pedaladasGrouped.forEach(group => {
            group.forEach(pedal => {
                pedalSort.push(pedal);
            });
        });

        return pedalSort;
    }

    async function updateBarChart() {

        console.log("Update BarChart ...");
        await removeBarChart();

        pedaladas_barChart = await sortBarChart();
        if (pedaladas_barChart.length > 0) {
            await createBoxBarChart();
            $('#pedaladas_barChart_card').show();
            await create_BarChart();
        }
    }
</script>