<script>
    async function generateMultiVis() {

        console.group("Gerando MultiVis");
        console.groupEnd();


        if (pedaladas_barChart.length > 0) {

            await updateMapChart();
            await updateRadarChart();
            await updateStreamChart();

        }
        updateButtonMultivis(false);
        totalStorage(); // Monitorando Storage
    }
</script>