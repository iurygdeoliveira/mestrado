<script>
    function renderData(content) {

        const data = sessionStorage.getItem(content);
        if (data) {
            console.log('existe' + content);
            return;
        }

        console.log('não existe' + content);
        if (getData(content)) {
            // Chamar mesmo bloco de funções do if
        }
        redirect('<?= url() ?>' + '/' + 'erro');
    }

    function render(data) {


    }
</script>