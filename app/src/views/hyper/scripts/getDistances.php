<script>
async function storeDistance(rider) {

    let data;
    if (!(await hasDistanceCyclist(rider))) {

        let index = parseInt(rider.replace(/[^0-9]/g, ''));
        data = await getDistances(rider);

        distances.push({
            cyclist: index,
            rides: data,
            max: await getMaxDistance(data)
        });
    }

    console.log("Distances Actives:");
    console.table(distances);
    return distances.rides;
}

async function hasDistanceCyclist(cyclist) {

    if (distances.length == 0) {
        return false;
    }

    const found = await filterDistance(cyclist);

    if (found == undefined) {
        return false;
    }

    if ((typeof found === 'object') && (found !== null)) {
        return true;
    }
}

async function getMaxDistance(distances) {
    return await Math.max(...distances.map(obj => obj.distance));
}

async function getDistances(cyclist) {

    console.log("Cyclist " + cyclist.replace(/[^0-9]/g, '') + " without distances");
    let distances_current = await getDistancesGithub(cyclist);
    return distances_current;
}

async function filterMaxDistance(cyclist) {
    let result = await filterDistance(cyclist);
    return result.max;
}

async function filterDistance(cyclist) {
    let index = parseInt(cyclist.replace(/[^0-9]/g, ''));
    return distances.find(element => element.cyclist === index);
}

async function filterRides(cyclist) {

    let result = await filterDistance(cyclist);
    return result.rides;
}
</script>