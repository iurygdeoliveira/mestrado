<script>
    // Cores utilizadas no checkbox riders
    let colors = ['rgb(211, 69, 91)', 'rgb(44, 136, 217)', 'rgb(247, 195, 37)', 'rgb(47, 177, 156)', 'rgb(115, 15, 195)'];
    let switchToggle = 'overview';
    let switchOrder = 'descending';
    let selected = []; // Array com o nome dos ciclistas selecionados
    let distances = [];
    let maxDistance = -1; // Distância maxima entre todas as pedaladas selecionadas

    // ************************************************
    // Constantes e variáveis utilizadas no tables lens modo itens

    let widthBox = 0; // Largura do box do table lens
    const min_height_lens = 10;
    const max_height_lens = 20;
    const margin_lens = 12; // Utilizado para dar espaço entre as linhas
    const padding_lens_first = 6; // Espaçamento entre as linhas
    const y_top = 6; // posição y para iniciar desenho da box
    const y_pos_inicial = 22; // posição y para iniciar desenhos das linhas
    const diff_height_box = 1; // diferença necessária para calcular a altura da box

    let pedaladas_red_clicadas = 0;
    let pedaladas_blue_clicadas = 0;
    let pedaladas_yellow_clicadas = 0;
    let pedaladas_green_clicadas = 0;
    let pedaladas_purple_clicadas = 0;

    // Definindo as Cores
    const background_lens = 'rgb(150,150,150)';
    const background_lens_focus = 'rgb(50,50,50)';

    store.session.set('colors_red', ['rgb(211, 69, 91)', 'rgb(116, 27, 40)', 'rgb(239, 189, 196)']);
    store.session.set('colors_red_current', ['rgb(211, 69, 91)', 'rgb(116, 27, 40)', 'rgb(239, 189, 196)']);

    store.session.set('colors_blue', ['rgb(44, 136, 217)', 'rgb(22, 75, 121)', 'rgb(186, 216, 242)']);
    store.session.set('colors_blue_current', ['rgb(44, 136, 217)', 'rgb(22, 75, 121)', 'rgb(186, 216, 242)']);

    store.session.set('colors_yellow', ['rgb(247, 195, 37)', 'rgb(138, 105, 5)', 'rgb(252, 233, 176)']);
    store.session.set('colors_yellow_current', ['rgb(247, 195, 37)', 'rgb(138, 105, 5)', 'rgb(252, 233, 176)']);

    store.session.set('colors_green', ['rgb(47, 177, 156)', 'rgb(30, 113, 98)', 'rgb(191, 238, 229)']);
    store.session.set('colors_green_current', ['rgb(47, 177, 156)', 'rgb(30, 113, 98)', 'rgb(191, 238, 229)']);

    store.session.set('colors_purple', ['rgb(115, 15, 195)', 'rgb(78,10,133)', 'rgb(218, 179, 249)']);
    store.session.set('colors_purple_current', ['rgb(115, 15, 195)', 'rgb(78,10,133)', 'rgb(218, 179, 249)']);


    // *********************************************
    // Constantes utilizadas em pedaladas_barChart
    store.session.set('pedaladas_barChart', []);
</script>