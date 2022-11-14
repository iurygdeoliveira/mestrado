<script>
    async function generateMultiVis() {


        console.group("Gerando MultiVis");
        if (pedaladas_barChart.length > 0) {
            await updateButtonMultivis(pedaladas_barChart, false, true, false);
            await getRecord(pedaladas_barChart[0]);
            await updateCharts();
            await updateButtonMultivis(pedaladas_barChart, true, false, false);
        }
        totalStorage(); // Monitorando Storage
    }

    async function updateCharts() {
        await updateBarChart();
        await updateMapChart();
        await updateRadarChart();
        //await updateStreamChart();
    }
</script>