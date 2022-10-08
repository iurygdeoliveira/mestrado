<script>
    // Obtendo dimensões de janela 
    let heightWindow = $(window).height();
    let widthWindow = $(window).width();
    let widthSidebar = $('#contentSidebar').width();
    d3.select('#contentSidebar').style('min-width', widthSidebar + 'px');
    let widthCharts = $('#contentCharts').width();
    console.log("Largura Janela: ", widthWindow, "Largura sidebar: ", widthSidebar, "Largura Charts: ", widthCharts);
    $(window).on('resize', function() {
        widthWindow = $(this).width();
        widthSidebar = $('#contentSidebar').width();
        widthCharts = $('#contentCharts').width();
        heightWindow = $(this).height();
        update_barChart();
        resizeMapChart();
        resizeModalTableLens();
    });
</script>

<?php $this->insert("../chartTableLens/variables_TableLens") ?>
<?php $this->insert("../chartBar/variables_BarChart") ?>
<?php $this->insert("../chartMap/variables_MapChart") ?>