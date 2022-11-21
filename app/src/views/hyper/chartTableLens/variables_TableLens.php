<script>
    // ***********************************************************
    // Constantes utilizadas no tables lens modo itens
    // ***********************************************************

    let switchToggle = 'overview';
    let switchOrder = 'descending';

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

    let colors_red_current = [normalRed, darkRed, lightRed];
    let colors_blue_current = [normalBlue, darkBlue, lightBlue];
    let colors_yellow_current = [normalYellow, darkYellow, lightYellow];
    let colors_green_current = [normalGreen, darkGreen, lightGreen];
    let colors_purple_current = [normalPurple, darkPurple, lightPurple];
</script>