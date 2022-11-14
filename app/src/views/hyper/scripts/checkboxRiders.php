<script>
    /**
     * COLORS USED IN THE CYCLIST CHECKBOX
     */
    let colors = [
        normalRed,
        normalBlue,
        normalYellow,
        normalGreen,
        normalPurple
    ];

    $('#rider1').on('click', click_handler);
    $('#rider2').on('click', click_handler);
    $('#rider3').on('click', click_handler);
    $('#rider4').on('click', click_handler);
    $('#rider5').on('click', click_handler);
    $('#rider6').on('click', click_handler);
    $('#rider7').on('click', click_handler);
    $('#rider8').on('click', click_handler);
    $('#rider9').on('click', click_handler);
    $('#rider10').on('click', click_handler);
    $('#rider11').on('click', click_handler);
    $('#rider12').on('click', click_handler);
    $('#rider13').on('click', click_handler);
    $('#rider14').on('click', click_handler);
    $('#rider15').on('click', click_handler);
    $('#rider16').on('click', click_handler);
    $('#rider17').on('click', click_handler);
    $('#rider18').on('click', click_handler);
    $('#rider19').on('click', click_handler);

    // Alternando modos de visualização do tablelens
    $('#switchToggle').on('click', function() {
        if (switchToggle == 'overview') {
            switchToggle = 'item';
            console.log('Alternando Table Lens para modo: ' + switchToggle);
        } else {
            switchToggle = 'overview';
            console.log('Alternando Table Lens para modo: ' + switchToggle);
        }
        tableLens();
    });

    $('#switchOrder').on('click', function() {
        if (switchOrder == 'descending') {
            switchOrder = 'ascending';
            console.log('Alternando Table Lens para modo: ' + switchOrder);
        } else {
            switchOrder = 'descending';
            console.log('Alternando Table Lens para modo: ' + switchOrder);
        }
        tableLens();
    });

    // Monitora os clicks do mouse nos checkbox dos ciclistas
    function click_handler() {

        let $this = $(this);

        if ($this.is(':checked')) {

            updateButtonSearchRiders(selected, false, true, false);
            storeDistance($this.attr("id")).then(() => {
                updateSlider(selected);
                tableLens();
                updateButtonSearchRiders(selected, true, false, false);
            });

            selected.push($this.attr("name"));
            d3.select(this).style('background-color', colors.shift());

        }

        if ($this.is(':not(:checked)')) {
            selected = arrayRemove(selected, $this.attr("name"))
            updateSlider(selected);
            updateCacheBarChart($this.attr("name"), true)
            getColor($(this));
            updatePedaladasClicked();
            updateButtonSearchRiders(selected, false, true, false);
            tableLens().then(() => {
                updateButtonSearchRiders(selected, true, false, false);
            });

        }

        // Atualizando checkbox
        if (selected.length >= 5) {
            disabledCheckBox();
        } else {
            enableCheckBox();
            enableTipsyTooltip('#search_rides', 'right');
        }

        if (selected.length <= 0) {
            removeBarChart();
            pedaladas_barChart = [];
            pedaladas_red_clicadas = 0;
            pedaladas_blue_clicadas = 0;
            pedaladas_yellow_clicadas = 0;
            pedaladas_green_clicadas = 0;
            pedaladas_purple_clicadas = 0;
            updateButtonMultivis(pedaladas_barChart, true, false, false);
        }
    }

    function arrayRemove(arr, value) {

        return arr.filter(function(ele) {
            return ele != value;
        });
    }

    function disabledCheckBox() {
        $("input:not(:checked)").each(function() {
            // console.log($(this).attr("id"));
            // Os botões switch não podem receber esse efeito
            let input = $(this).attr("id");
            if ((input != 'switchToggle') && (input != 'switchOrder')) {
                document.getElementById($(this).attr("id")).disabled = true;
            }

        });
    }

    function enableCheckBox() {
        $("input:not(:checked)").each(function() {

            // Os botões switch não podem receber esse efeito
            let input = $(this).attr("id");
            if ((input != 'switchToggle') && (input != 'switchOrder')) {
                document.getElementById($(this).attr("id")).disabled = false;
                $(this).css('background-color', 'white');
                //console.log(colors);
            }

        });
    }

    function getColor(element) {
        colors.push(element.css('background-color'));
    }

    function updatePedaladasClicked() {
        // console.log(colors);

        colors.forEach(element => {

            switch (element) {
                case normalRed:
                    pedaladas_red_clicadas = 0;
                    break;
                case normalBlue:
                    pedaladas_blue_clicadas = 0;
                    break;
                case normalYellow:
                    pedaladas_yellow_clicadas = 0;
                    break;
                case normalGreen:
                    pedaladas_green_clicadas = 0;
                    break;
                case normalPurple:
                    pedaladas_purple_clicadas = 0;
                    break;
            }
        });

    }
</script>