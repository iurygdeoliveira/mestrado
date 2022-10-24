<script>
    async function executeRequest(path) {

        let github = await import('<?= CONF_URL_GITHUB ?>');

        return await github.request({
            method: "GET",
            url: '<?= CONF_URL_REPO ?>',
            headers: {
                authorization: '<?= CONF_GITHUB_TOKEN ?>',
            },
            owner: "iurygdeoliveira",
            repo: "cyclevis_dataset",
            path: path
        });

    }

    async function getDataGithub(path) {

        return await executeRequest(path);
    }

    async function getDistancesGithub(cyclist) {

        let pathCyclist = "Cyclist_" + cyclist.replace(/[^0-9]/g, '');

        let response = await getDataGithub(pathCyclist + '/all_distances.json');
        let distances_url = response.data.download_url;

        let data = await d3.json(distances_url,
            data => {
                return data
            }
        );

        let distances = data.all_distances.split("|");
        distances = distances.map((element) => {
            let aux = element.split(",");
            let distance = aux[0].split(":");
            let id = aux[1].split(":");
            let data = {
                'distance': parseFloat(distance[1]),
                'id': parseFloat(id[1])
            };
            return data;
        });
        return distances;
    }

    function extractUrlDownload(arr, value) {

        let element = arr.filter(function(ele) {
            return ele.name === value;
        });

        return element[0].download_url;
    }

    async function getPedaladaGithub(cyclist, pedalada) {

        let pathCyclist = "Cyclist_" + cyclist.replace(/[^0-9]/g, '') + '/';

        let pedal = pedalada.split("_");
        pedal = pedal[2];

        let response = await getDataGithub(pathCyclist + 'pedal' + pedal);

        let urls = [
            extractUrlDownload(response.data, 'distance_history.json'),
            extractUrlDownload(response.data, 'elevation_google.json'),
            extractUrlDownload(response.data, 'heartrate_history.json'),
            extractUrlDownload(response.data, 'speed_history.json'),
            extractUrlDownload(response.data, 'time_history.json'),
            extractUrlDownload(response.data, 'latitudes.json'),
            extractUrlDownload(response.data, 'longitudes.json'),
            extractUrlDownload(response.data, 'overview.json'),
        ];

        const promises = urls.map(async (url_current, idx) => {
            return await d3.json(url_current,
                data => {
                    return data
                }
            );
        });

        return await Promise.all(promises);
    }
</script>