<script>
    function enableTooltipsLine() {
        $("[line_clicked]").tipsy({
            arrowWidth: 10, //arrow css border-width + margin-(left|right), default is 5 + 5
            cls: null, //tipsy custom class
            duration: 150, //tipsy fadeIn, fadeOut duration
            offset: 6, //tipsy offset from element
            position: 'bottom-center', //tipsy position - top-left | top-center | top-right | bottom-left | bottom-center | bottom-right | left | right
            trigger: 'hover', // how tooltip is triggered - hover | focus | click | manual
            onShow: null, //onShow event
            onHide: null //onHide event
        });
    }

    $('#search_rides').tipsy({
        arrowWidth: 10, //arrow css border-width + margin-(left|right), default is 5 + 5
        cls: null, //tipsy custom class
        duration: 150, //tipsy fadeIn, fadeOut duration
        offset: 7, //tipsy offset from element
        position: 'right', //tipsy position - top-left | top-center | top-right | bottom-left | bottom-center | bottom-right | left | right
        trigger: 'hover', // how tooltip is triggered - hover | focus | click | manual
        onShow: null, //onShow event
        onHide: null //onHide event
    });
</script>