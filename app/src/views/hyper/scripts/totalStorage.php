<script>
    var total = 0;
    for (var x in sessionStorage) {

        if (sessionStorage[x].length != undefined) {
            var amount = (sessionStorage[x].length * 2) / 1024 / 1024;
            total += amount;
        }
        //console.log(x + " = " + amount.toFixed(2) + " MB");
    }
    console.log("Total Storage Session: " + total + " MB");
</script>