<script>
    /**
     * WINDOW DIMENSIONS
     */
    let heightWindow = $(window).height();
    let widthWindow = $(window).width();
    let widthSidebar = $('#contentSidebar').width();
    d3.select('#contentSidebar').style('min-width', widthSidebar + 'px');
    let widthCharts = $('#contentCharts').width();
    console.log("Altura Janela: ", heightWindow, "Largura Janela: ", widthWindow);
    $(window).on('resize', function() {

        if (store.session.get('pedaladas_barChart').length > 0) {
            widthWindow = $(this).width();
            widthSidebar = $('#contentSidebar').width();
            widthCharts = $('#contentCharts').width();
            heightWindow = $(this).height();
            update_barChart();
            resizeMapChart();
            resizeModalTableLens();
        }
    });

    /**
     * COLORS
     */
    const lightRed = 'rgb(216, 162, 169)'; // hsl(352, 41%, 74%)
    const normalRed = 'rgb(211, 69, 90)'; // hsl(351, 62%, 55%)
    const darkRed = 'rgb(116, 27, 40)'; // hsl(351, 62%, 28%)

    const lightBlue = 'rgb(150, 191, 227)'; // hsl(208, 58%, 74%)
    const normalBlue = 'rgb(44, 136, 216)'; // hsl(208, 69%, 51%)
    const darkBlue = 'rgb(22, 75, 121)'; // hsl(208, 69%, 28%)

    const lightYellow = 'rgb(237, 213, 140)'; // hsl(45, 73%, 74%)
    const normalYellow = 'rgb(247, 195, 38)'; // hsl(45, 93%, 56%)
    const darkYellow = 'rgb(138, 105, 5)'; // hsl(45, 93%, 28%)

    const lightGreen = 'rgb(164, 214, 205)'; // hsl(169, 38%, 74%)
    const normalGreen = 'rgb(47, 177, 156)'; // hsl(170, 58%, 44%)
    const darkGreen = 'rgb(22, 80, 70)'; // hsl(170, 57%, 20%)

    const lightPurple = 'rgb(193, 146, 232)'; // hsl(273, 65%, 74%)
    const normalPurple = 'rgb(162, 65, 241)'; // hsl(273, 86%, 60%)
    const darkPurple = 'rgb(83, 11, 142)'; // hsl(273, 86%, 30%)
</script>
<?php $this->insert("../scripts/cachePedaladas") ?>
<?php $this->insert("../chartTableLens/variables_TableLens") ?>
<?php $this->insert("../chartBar/variables_BarChart") ?>
<?php $this->insert("../chartMap/variables_MapChart") ?>