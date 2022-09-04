<script>
    async function searchRiders() {


        console.log(selected);

        $('#button_carregar_' + rider).hide();
        $('#button_danger_' + rider).hide();
        $('#button_loading_' + rider).show();
        // var data = new FormData();
        // data.set('rider', rider);


        //     .then(function(res) {

        //         if (res.data.status === true) {
        //             console.log(res.data.message);
        //             return res.data.response;
        //         }

        //         if (res.data.status === false) {
        //             console.log(res.data.message);
        //             return -1;
        //         }

        //     })
        //     .catch(function(error) {
        //         console.log("Erro");
        //         console.log(error);
        //         console.log(error.res.data);
        //         console.log(error.res.status);
        //         console.log(error.res.headers);
        //         return -1;
        //     });

    }
</script>