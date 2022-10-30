<script>
    async function generateMultiVis() {

        console.group("Gerando MultiVis");
        console.groupEnd();

        if (store.session.get('pedaladas_barChart').length > 0) {

            await updateMapChart();
            await updateRadarChart();
        }
        updateButtonMultivis(false);
        totalStorage(); // Monitorando Storage
    }
</script>