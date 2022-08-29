<script>
    selected = [];
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

    function click_handler() {
        // converte um HTMLElement para um objeto jQuery
        let $this = $(this);
        if ($this.is(':checked')) {
            selected.push($this.attr("name"));
            console.log(selected);
        } else {
            let value = $this.attr("name");
            selected = arrayRemove(selected, $this.attr("name"))
            console.log(selected);
        }
    }

    function arrayRemove(arr, value) {

        return arr.filter(function(ele) {
            return ele != value;
        });
    }
</script>