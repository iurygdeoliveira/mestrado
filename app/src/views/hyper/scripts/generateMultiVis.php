<script>
    async function generateMultiVis() {


        console.group("Gerando MultiVis");
        if (pedaladas_barChart.length > 0) {
            await updateButtonMultivis(pedaladas_barChart, false, true, false);
            await updateBarChart();
            await updateStreamChart();
            await updateMapChart();
            await updateRadarChart();
            await updateButtonMultivis(pedaladas_barChart, true, false, false);
        }
        totalStorage(); // Monitorando Storage
    }
</script>