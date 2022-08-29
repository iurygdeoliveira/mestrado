<script>
    let rider_1 = $('#select_rider_1');


    let rider_2 = $('#select_rider_2');

    // cria um "grupo" com os checkbox
    let riders = rider_1.add(rider_2);

    let rider_3 = $('#select_rider_3');
    riders = riders.add(rider_3);

    let rider_4 = $('#select_rider_4');
    riders = riders.add(rider_4);

    let rider_5 = $('#select_rider_5');
    riders = riders.add(rider_5);

    let rider_6 = $('#select_rider_6');
    riders = riders.add(rider_6);

    let rider_7 = $('#select_rider_7');
    riders = riders.add(rider_7);

    let rider_8 = $('#select_rider_8');
    riders = riders.add(rider_8);

    let rider_9 = $('#select_rider_9');
    riders = riders.add(rider_9);

    let rider_10 = $('#select_rider_10');
    riders = riders.add(rider_10);

    let rider_11 = $('#select_rider_11');
    riders = riders.add(rider_11);

    let rider_12 = $('#select_rider_12');
    riders = riders.add(rider_12);

    let rider_13 = $('#select_rider_13');
    riders = riders.add(rider_13);

    let rider_14 = $('#select_rider_14');
    riders = riders.add(rider_14);

    let rider_15 = $('#select_rider_15');
    riders = riders.add(rider_15);

    let rider_16 = $('#select_rider_16');
    riders = riders.add(rider_16);

    let rider_17 = $('#select_rider_17');
    riders = riders.add(rider_17);

    let rider_18 = $('#select_rider_18');
    riders = riders.add(rider_18);

    let rider_19 = $('#select_rider_19');
    riders = riders.add(rider_19);

    function click_handler(event) {
        // converte um HTMLElement para um objeto jQuery
        let $this = $(this);

        // Recupera a quantidade de clicks, senão houver recebe zero
        let clicks = $this.data('clicks') || 0;

        // Incrementa 'clicks' no botão clicado
        $this.data('clicks', clicks + 1);

        // Apenas para visualização dos dados
        console.log('Clicks no botão 1: ' + rider_1.data('clicks'));
        console.log('Clicks no botão 2: ' + rider_2.data('clicks'));
        console.log('Clicks no botão 3: ' + rider_3.data('clicks'));
        console.log('Clicks no botão 4: ' + rider_4.data('clicks'));
        console.log('Clicks no botão 5: ' + rider_5.data('clicks'));
        console.log('Clicks no botão 6: ' + rider_6.data('clicks'));
        console.log('Clicks no botão 7: ' + rider_7.data('clicks'));
        console.log('Clicks no botão 8: ' + rider_8.data('clicks'));
        console.log('Clicks no botão 9: ' + rider_9.data('clicks'));
        console.log('Clicks no botão 10: ' + rider_10.data('clicks'));
        console.log('Clicks no botão 11: ' + rider_11.data('clicks'));
        console.log('Clicks no botão 12: ' + rider_12.data('clicks'));
        console.log('Clicks no botão 13: ' + rider_13.data('clicks'));
        console.log('Clicks no botão 14: ' + rider_14.data('clicks'));
        console.log('Clicks no botão 15: ' + rider_15.data('clicks'));
        console.log('Clicks no botão 16: ' + rider_16.data('clicks'));
        console.log('Clicks no botão 17: ' + rider_17.data('clicks'));
        console.log('Clicks no botão 18: ' + rider_18.data('clicks'));
        console.log('Clicks no botão 19: ' + rider_19.data('clicks'));
        console.log('Total de Clicks:' + clicks);
        console.log('-----');
    }

    riders.on('click', click_handler);
</script>