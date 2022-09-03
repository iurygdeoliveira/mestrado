<script>
    selected = [];
    colors = ['rgb(211, 69, 91)', 'rgb(44, 136, 217)', 'rgb(247, 195, 37)', 'rgb(47, 177, 156)', 'rgb(115, 15, 195)']
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

    // Monitora os clicks do mouse
    function click_handler() {
        // converte um HTMLElement para um objeto jQuery
        let $this = $(this);
        if ($this.is(':checked')) {
            selected.push($this.attr("name"));
            $(this).css('background-color', colors.shift())
            //console.log(colors);
        }

        if ($this.is(':not(:checked)')) {
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

        updateSlider(selected);
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