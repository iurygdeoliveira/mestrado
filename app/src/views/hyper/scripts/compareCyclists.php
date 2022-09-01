<script>
    selected = [];
    colors = ['rgb(211, 69, 91)', 'rgb(44, 136, 217)', 'rgb(247, 195, 37)', 'rgb(47, 177, 156)', 'rgb(115, 15, 195)']
    $('#select_rider_1').on('click', click_handler);
    $('#select_rider_2').on('click', click_handler);
    $('#select_rider_3').on('click', click_handler);
    $('#select_rider_4').on('click', click_handler);
    $('#select_rider_5').on('click', click_handler);
    $('#select_rider_6').on('click', click_handler);
    $('#select_rider_7').on('click', click_handler);
    $('#select_rider_8').on('click', click_handler);
    $('#select_rider_9').on('click', click_handler);
    $('#select_rider_10').on('click', click_handler);
    $('#select_rider_11').on('click', click_handler);
    $('#select_rider_12').on('click', click_handler);
    $('#select_rider_13').on('click', click_handler);
    $('#select_rider_14').on('click', click_handler);
    $('#select_rider_15').on('click', click_handler);
    $('#select_rider_16').on('click', click_handler);
    $('#select_rider_17').on('click', click_handler);
    $('#select_rider_18').on('click', click_handler);
    $('#select_rider_19').on('click', click_handler);

    // Monitora os clicks do mouse
    function click_handler() {
        // converte um HTMLElement para um objeto jQuery
        let $this = $(this);
        if ($this.is(':checked')) {
            selected.push($this.attr("name"));
            $(this).css('background-color', colors.shift())
            //console.log(colors);
        } else {
            let value = $this.attr("name");
            selected = arrayRemove(selected, $this.attr("name"))
            getColor($(this));
            // console.log(selected);
        }

        if (selected.length >= 5) {
            disabledCheckBox();
        } else {
            enableCheckBox();
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
            document.getElementById($(this).attr("id")).disabled = true;
        });
    }

    function enableCheckBox() {
        $("input:not(:checked)").each(function() {
            document.getElementById($(this).attr("id")).disabled = false;
            $(this).css('background-color', 'white');
            //console.log(colors);

        });
    }

    function getColor(element) {
        colors.push(element.css('background-color'));
    }
</script>