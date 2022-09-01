<script>
    $(function() {
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 500,
            values: [0, 500],
            slide: function(event, ui) {
                $("#distance").text(ui.values[0] + " KM - " + ui.values[1] + " KM");
            }
        });
        $("#distance").text($("#slider-range").slider("values", 0) +
            " KM - " + $("#slider-range").slider("values", 1) + " KM");
    });

    function backgroundSlider() {

    }
</script>