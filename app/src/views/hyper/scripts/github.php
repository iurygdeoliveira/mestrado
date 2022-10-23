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

    function extractPathFile(arr, value) {

        let element = arr.filter(function(ele) {
            if (ele.name === value) {
                return ele;
            };
        });

        return element[0].path;
    }

    async function mountArrayUrls(distances) {

        let arrayUrls = [];
        const promises = distances.map(async (distance_current, idx) => {

            let res2 = await getDataGithub(distance_current.path);
            let overviewPath = extractPathFile(res2.data, 'overview.json');
            let res3 = await getDataGithub(overviewPath);
            arrayUrls.push(res3.data.download_url);
        });

        await Promise.all(promises);
        return arrayUrls;
    }

    async function mountArrayDistances(arrayUrls) {

        let arrayDistances = [];

        const promises = arrayUrls.map(async (url_current, idx) => {

            //console.log(url_current);
            let data = await d3.json(url_current,
                data => {
                    return data
                }
            );

            arrayDistances.push(parseFloat(data.distance));

        });

        await Promise.all(promises);

        return arrayDistances;
    }

    async function getDistancesGithub(cyclist) {

        let pathCyclist = "Cyclist_" + cyclist.replace(/[^0-9]/g, '');

        let res1 = await getDataGithub(pathCyclist);
        let distances = res1.data;

        let arrayUrls = await mountArrayUrls(distances);

        let arrayDistances = await mountArrayDistances(arrayUrls);
        console.log(arrayDistances);

        return null;

    }
</script>