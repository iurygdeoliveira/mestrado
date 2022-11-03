<script>
    async function generateMultiVis(resize) {

        console.group("Gerando MultiVis");
        console.groupEnd();


        if (store.session.get('pedaladas_barChart').length > 0) {

            await updateMapChart();
            await updateRadarChart();
        }
        updateButtonMultivis('void');
        totalStorage(); // Monitorando Storage
    }
</script>