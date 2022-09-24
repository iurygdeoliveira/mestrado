<script>
    function enableTooltips() {
        $('svg line').tipsy({
            trigger: 'hover',
            gravity: 's',
            fade: true,
            follow: 'x',
            html: true,
            title: function() {
                return '<span style="font-size: 12px; font-weight: bold;">' + $(this).attr('tooltip') + '</span>';
            }
        });
    }
</script>