<script>
    async function createElement(rider, item) {


        let newDivElement = document.createElement('div');

        d3.select(newDivElement)
            .attr("id", rider + "_pedalada_" + item.id)
            .attr("rider", rider)
            .attr("line_clicked", 'false')
            .attr("color_selected", 'false')
            .attr("distance", item.distance)
            .attr("title", item.distance.toFixed(2) + " KM")
            .style('display', 'block')
            .style('width', 100 + '%')
            .style('background-color', '#fff')
            .style('padding', 10)
            .style('margin-bottom', 10)
            .style('margin-top', 10)
            .style('border', '0.1px solid ' + '#fff');

        return newDivElement;
    }

    async function extractOutliers(rider, table, total, url_readData) {

        $('#button_carregar_' + rider).hide();
        $('#button_danger_' + rider).hide();
        $('#button_loading_' + rider).show();

        let resultado = await getDistances('rider' + rider);
        pedaladas_barChart = [];
        for (const iterator of resultado) {

            let elemento = await createElement('rider' + rider, iterator);
            let push_barChart = await prepare_pedalada_barChart(elemento);
            let res = await storePedalada(push_barChart);
            push_barChart = await mount_pedalada_barChart(push_barChart, res);
            pedaladas_barChart.push(push_barChart);
        }

        let index = 0;
        let elevation = [];
        console.log(pedaladas_barChart);
        for (const element of pedaladas_barChart) {

            if (await checkStreamNull(element.id)) {

                let segments = await createSegment(element);
                let heartStream = await createStream(
                    segments[element.id],
                    element.heartrate_history,
                    element.id
                );

                let elevationStream = await createStream(
                    segments[element.id],
                    element.elevation_history,
                    element.id
                );

                elevation.push({
                    'id': element.id,
                    'distance': element.distance,
                    'ele': elevationStream.max,
                    'dec': elevationStream.min
                })

                let speedStream = await createStream(
                    segments[element.id],
                    element.speed_history,
                    element.id
                );


                if (speedStream.avg <= 10) {
                    speedStream.id = element.id;
                    avg.push(speedStream)
                }

                await modifyPedalada(element);

            }

            index++;
            let porcentagem = ((100 * index) / parseInt(total)).toFixed(2);
            $('#progress_bar_' + rider).attr('style', "width: " + porcentagem + "%;");
            $('#progress_bar_' + rider).attr('aria-valuenow', porcentagem);
            $('#progress_bar_' + rider).text(porcentagem + "%");
        }

        elevation.sort(function(a, b) {
            if (a.ele < b.ele) {
                return 1;
            }
            if (a.ele > b.ele) {
                return -1;
            }
            // a must be equal to b
            return 0;
        });
        console.log(elevation);

        $('#button_loading_' + rider).hide();
        $('#button_success_' + rider).show();

    }

    async function extractActivities(rider, table, total, url_readData) {

        $('#button_carregar_' + rider).hide();
        $('#button_danger_' + rider).hide();
        $('#button_loading_' + rider).show();
        var data = new FormData();
        data.append('rider', 'rider' + rider);
        data.append('atividade', 0);

        let index;
        for (index = 1; index <= parseInt(total); index++) {

            data.set('atividade', index);
            await axios.post(url_readData, data)
                .then(function(response) {

                    if (response.data.status === true) {
                        console.log(response.data.message);
                        let porcentagem = ((100 * index) / parseInt(total)).toFixed(2);
                        $('#progress_bar_' + rider).attr('style', "width: " + porcentagem + "%;");
                        $('#progress_bar_' + rider).attr('aria-valuenow', porcentagem);
                        $('#progress_bar_' + rider).text(porcentagem + "%");
                    }

                    if (response.data.status === false) {
                        console.log(response.data.message);
                        console.log('erro ao buscar');
                        $('#button_carregar_' + rider).hide();
                        $('#button_loading_' + rider).hide();
                        $('#button_success_' + rider).hide();
                        $('#button_danger_' + rider).show();
                        $('#progress_bar_' + rider).hide();
                        $('#rider_' + rider + '_error').text(response.data.message);
                        $('#rider_' + rider + '_error').show();
                        index = parseInt(total) + 2; // Parar laço de repetição
                    }

                })
                .catch(function(error) {
                    console.log("Erro");
                    console.log(error);
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                    $('#button_carregar_' + rider).hide();
                    $('#button_loading_' + rider).hide();
                    $('#button_success_' + rider).hide();
                    $('#button_danger_' + rider).show();
                    index = parseInt(total) + 2; // Parar laço de repetição
                });
        }
        $('#button_loading_' + rider).hide();

        if (index == parseInt(total) + 1) {

            $('#button_success_' + rider).show();

        }

    }

    async function generateBbox(rider, table, total, url_getCoordinates, url_sendBbox) {

        $('#button_carregar_' + rider).hide();
        $('#button_danger_' + rider).hide();
        $('#button_loading_' + rider).show();
        var data = new FormData();
        data.append('rider', 'rider' + rider);
        data.append('atividade', 0);

        let index;

        // Inicializando indexedDB
        var dbAux = new Dexie("rider" + rider);
        dbAux.version(1).stores({
            coordinates: 'id,rider,lat_lon'
        });

        for (index = 1; index <= parseInt(total); index++) {

            data.set('atividade', index);
            await axios.post(url_getCoordinates, data)
                .then(function(response) {

                    if (response.data.status === true) {
                        console.log(response.data.message);
                        let porcentagem = ((100 * index) / parseInt(total)).toFixed(2);
                        $('#progress_bar_' + rider).attr('style', "width: " + porcentagem + "%;");
                        $('#progress_bar_' + rider).attr('aria-valuenow', porcentagem);
                        $('#progress_bar_' + rider).text(porcentagem + "%");
                        //console.log(response.data.response);
                        dbAux.coordinates.add({
                            id: index,
                            rider: rider,
                            lat_lon: response.data.response
                        });

                    }

                    if (response.data.status === false) {
                        console.log(response.data.message);
                        console.log('erro ao buscar');
                        $('#button_carregar_' + rider).hide();
                        $('#button_loading_' + rider).hide();
                        $('#button_success_' + rider).hide();
                        $('#button_danger_' + rider).show();
                        $('#progress_bar_' + rider).hide();
                        $('#rider_' + rider + '_error').text(response.data.message);
                        $('#rider_' + rider + '_error').show();
                        index = parseInt(total) + 2; // Parar laço de repetição
                    }

                })
                .catch(function(error) {
                    console.log("Erro");
                    console.log(error);
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                    $('#button_carregar_' + rider).hide();
                    $('#button_loading_' + rider).hide();
                    $('#button_success_' + rider).hide();
                    $('#button_danger_' + rider).show();
                    index = parseInt(total) + 2; // Parar laço de repetição
                });
        }
        $('#button_loading_' + rider).hide();

        if (index == parseInt(total) + 1) {
            $('#button_success_' + rider).show();
        }

        let collection = dbAux.coordinates.toCollection();
        collection.each(async function(coordinates) {
            let lineString = [];

            coordinates.lat_lon.forEach(element => {
                element = element.split("|");
                element[0] = parseFloat(element[0]);
                element[1] = parseFloat(element[1]);
                lineString.push(element);
            });
            //console.log(lineString);
            var line = turf.lineString(lineString);
            var bbox = turf.bbox(line);
            var bboxPolygon = turf.bboxPolygon(bbox);
            var centroid = turf.centroid(bboxPolygon);
            //console.log(bboxPolygon.geometry.coordinates[0]);
            //console.log(centroid.geometry.coordinates);

            data = new FormData();
            data.append('rider', coordinates.rider);
            data.append('atividade', coordinates.id);
            data.append('bbox', JSON.stringify(bboxPolygon.geometry.coordinates[0]));
            data.append('centroid', JSON.stringify(centroid.geometry.coordinates));
            console.log("enviando");
            await axios.post(url_sendBbox, data)
                .then(function(response) {

                    if (response.data.status === true) {
                        console.log(response.data.message);
                        let porcentagem = ((100 * index) / parseInt(total)).toFixed(2);
                        $('#progress_bar_' + rider).attr('style', "width: " + porcentagem + "%;");
                        $('#progress_bar_' + rider).attr('aria-valuenow', porcentagem);
                        $('#progress_bar_' + rider).text(porcentagem + "%");

                    }

                    if (response.data.status === false) {
                        console.log(response.data.message);
                        console.log('erro ao buscar');
                        $('#button_carregar_' + rider).hide();
                        $('#button_loading_' + rider).hide();
                        $('#button_success_' + rider).hide();
                        $('#button_danger_' + rider).show();
                        $('#progress_bar_' + rider).hide();
                        $('#rider_' + rider + '_error').text(response.data.message);
                        $('#rider_' + rider + '_error').show();
                        index = parseInt(total) + 2; // Parar laço de repetição
                    }

                })
                .catch(function(error) {
                    console.log("Erro");
                    console.log(error);
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                    $('#button_carregar_' + rider).hide();
                    $('#button_loading_' + rider).hide();
                    $('#button_success_' + rider).hide();
                    $('#button_danger_' + rider).show();
                    index = parseInt(total) + 2; // Parar laço de repetição
                });
        });

    }

    async function identifyFiles(rider, table, total, url_identifyFiles) {

        $('#button_carregar_' + rider).hide();
        $('#button_danger_' + rider).hide();
        $('#button_loading_' + rider).show();
        var data = new FormData();
        data.append('rider', 'rider' + rider);
        data.append('atividade', 0);

        let index;

        for (index = 1; index <= parseInt(total); index++) {

            data.set('atividade', index);
            await axios.post(url_identifyFiles, data)
                .then(function(response) {

                    if (response.data.status === true) {
                        console.log(response.data.message);
                        let porcentagem = ((100 * index) / parseInt(total)).toFixed(2);
                        $('#progress_bar_' + rider).attr('style', "width: " + porcentagem + "%;");
                        $('#progress_bar_' + rider).attr('aria-valuenow', porcentagem);
                        $('#progress_bar_' + rider).text(porcentagem + "%");
                        console.log(response.data.response);
                    }

                    if (response.data.status === false) {
                        console.log(response.data.message);
                        console.log('erro ao buscar');
                        $('#button_carregar_' + rider).hide();
                        $('#button_loading_' + rider).hide();
                        $('#button_success_' + rider).hide();
                        $('#button_danger_' + rider).show();
                        $('#progress_bar_' + rider).hide();
                        $('#rider_' + rider + '_error').text(response.data.message);
                        $('#rider_' + rider + '_error').show();
                        index = parseInt(total) + 2; // Parar laço de repetição
                    }

                })
                .catch(function(error) {
                    console.log("Erro");
                    console.log(error);
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                    $('#button_carregar_' + rider).hide();
                    $('#button_loading_' + rider).hide();
                    $('#button_success_' + rider).hide();
                    $('#button_danger_' + rider).show();
                    index = parseInt(total) + 2; // Parar laço de repetição
                });
        }
        $('#button_loading_' + rider).hide();

        if (index == parseInt(total) + 1) {
            $('#button_success_' + rider).show();
        }

    }
</script>