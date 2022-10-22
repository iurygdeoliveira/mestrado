<script>
    /**
     * WINDOW DIMENSIONS
     */

    let heightWindow = $(window).height();
    let widthWindow = $(window).width();
    let widthSidebar = $('#contentSidebar').width();
    d3.select('#contentSidebar').style('min-width', widthSidebar + 'px');
    let widthCharts = $('#contentCharts').width();
    //console.log("Largura Janela: ", widthWindow, "Largura sidebar: ", widthSidebar, "Largura Charts: ", widthCharts);
    $(window).on('resize', function() {
        widthWindow = $(this).width();
        widthSidebar = $('#contentSidebar').width();
        widthCharts = $('#contentCharts').width();
        heightWindow = $(this).height();
        update_barChart();
        resizeMapChart();
        resizeModalTableLens();
    });

    /**
     * COLORS
     */

    let lightRed = 'hsl(352, 61%, 84%)';
    let normalRed = new Color("hsl", [351, 62, 55]);
    let darkRed = new Color("hsl", [351, 62, 28]);

    let lightBlue = new Color("hsl", [208, 68, 84]);
    let normalBlue = new Color("hsl", [208, 69, 51]);
    let darkBlue = new Color("hsl", [208, 69, 28]);

    let lightYellow = new Color("hsl", [45, 93, 84]);
    let normalYellow = new Color("hsl", [45, 93, 56]);
    let darkYellow = new Color("hsl", [45, 93, 28]);

    let lightGreen = new Color("hsl", [169, 58, 84]);
    let normalGreen = new Color("hsl", [170, 58, 44]);
    let darkGreen = new Color("hsl", [170, 57, 20]);

    let lightPurple = new Color("hsl", [273, 85, 84]);
    let normalPurple = new Color("hsl", [273, 86, 50]);
    let darkPurple = new Color("hsl", [273, 86, 30]);
</script>

<?php $this->insert("../chartTableLens/variables_TableLens") ?>
<?php $this->insert("../chartBar/variables_BarChart") ?>
<?php $this->insert("../chartMap/variables_MapChart") ?>