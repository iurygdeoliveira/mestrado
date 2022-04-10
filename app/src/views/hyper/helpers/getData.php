<script>
    async function getData(content) {

        if (sessionStorage.getItem(content)) {
            return;
        }

        await axios.post('<?= url() ?>' + '/' + content)
            .then(function(response) {

                if (response.data.status === true) {
                    console.log(response.data.message);
                    console.log(response.data.response);
                    sessionStorage.setItem(content, response.data.response);
                    return true;
                }

                if (response.data.status === false) {
                    console.log(response.data.message);
                    console.log(response.data.response);
                    sessionStorage.setItem(content, false);
                    return false;
                }

            })
            .catch(function(error) {
                console.log("Erro");
                console.log(error.response.data);
                console.log(error.response.status);
                console.log(error.response.headers);
                sessionStorage.setItem(content, false);
                return false;
            });
    }
</script>