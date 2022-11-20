<script>
    // ***********************************************************
    // Constantes utilizadas no tables lens modo itens
    // ***********************************************************

    let switchToggle = 'overview';
    let switchOrder = 'descending';
    let selected = []; // Array com o nome dos ciclistas selecionados
    let maxDistance = -1; // Distância maxima entre todas as pedaladas selecionadas

    // ***********************************************************
    // Constantes e variáveis utilizadas no tables lens modo itens
    // ***********************************************************

    // Controle da quantidade de linhas clicadas de cada ciclista
    let pedaladas_red_clicadas = 0;
    let pedaladas_blue_clicadas = 0;
    let pedaladas_yellow_clicadas = 0;
    let pedaladas_green_clicadas = 0;
    let pedaladas_purple_clicadas = 0;

    // controle das dimensões das linhas
    const padding_item = '6px';
    const margin_item = '1px';
    const padding_overview = '0px';
    const margin_overview = '0px';

    // Definindo as Cores
    const background_lens = 'rgb(150,150,150)';
    const background_lens_focus = 'rgb(50,50,50)';

    store.session.set('colors_red', [normalRed, darkRed, lightRed]);
    store.session.set('colors_red_current', [normalRed, darkRed, lightRed]);

    store.session.set('colors_blue', [normalBlue, darkBlue, lightBlue]);
    store.session.set('colors_blue_current', [normalBlue, darkBlue, lightBlue]);

    store.session.set('colors_yellow', [normalYellow, darkYellow, lightYellow]);
    store.session.set('colors_yellow_current', [normalYellow, darkYellow, lightYellow]);

    store.session.set('colors_green', [normalGreen, darkGreen, lightGreen]);
    store.session.set('colors_green_current', [normalGreen, darkGreen, lightGreen]);

    store.session.set('colors_purple', [normalPurple, darkPurple, lightPurple]);
    store.session.set('colors_purple_current', [normalPurple, darkPurple, lightPurple]);
</script>