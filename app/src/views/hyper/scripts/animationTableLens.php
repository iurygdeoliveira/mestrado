<script>
    function animationTableLens() {

        pedaladas_red_clicadas = 0;
        pedaladas_blue_clicadas = 0;
        pedaladas_yellow_clicadas = 0;
        pedaladas_green_clicadas = 0;
        pedaladas_purple_clicadas = 0;

        let lines = d3.selectAll('rect')
            .on('mouseover', function() {

                // Habilitar animação apenas nas pedaladas não clicadas
                if (disableAnimationBox(this)) {

                    if (($(this).attr("pedalada_clicada") == 'false')) {
                        // descobrindo pedalada focada
                        let pedalada_mouseover = $(this).attr("id").split("_");

                        //console.log("pedalada focada:", pedalada_mouseover);
                        let pedaladas_selected = store.session.get(pedalada_mouseover[0] + '_selected').pedaladas_selected;
                        //console.log("pedaladas selecionadas: ", pedaladas_selected);

                        // abaixando 20 pixels a posição das pedaladas
                        // abaixo da pedalada focada
                        // usando parseInt para converter id da pedalada focada de string para numerico na base 10
                        let id_pedalada_mouseover = parseInt(pedalada_mouseover[2], 10);
                        //console.log("id da pedalada focada:", id_pedalada_mouseover);

                        // Obtendo index no array pedaldas_selected da pedalada focada
                        let index_pedalada_mouseover = pedaladas_selected.map(object => object.id).indexOf(id_pedalada_mouseover);
                        //console.log("indice da pedalada focada:", index_pedalada_mouseover);

                        if (index_pedalada_mouseover == 0) {
                            lineFirstOver(this, index_pedalada_mouseover, pedalada_mouseover, pedaladas_selected);
                        } else {
                            lineOthersOver(this, index_pedalada_mouseover, pedalada_mouseover, pedaladas_selected);
                        }
                    }
                }

            })
            .on('mouseout', function() {

                if (disableAnimationBox(this)) {

                    if ($(this).attr("pedalada_clicada") == 'false') {

                        let pedalada_mouseout = $(this).attr("id").split("_");

                        // subindo 20 pixels a posição das pedaladas
                        // abaixo da pedalada focada
                        // usando parseInt para converter id da pedalada focada de string para numerico na base 10
                        let pedaladas_selected = store.session.get(pedalada_mouseout[0] + '_selected').pedaladas_selected;
                        // console.log("pedaladas selecionadas: ", pedaladas_selected);
                        // console.log("pedalada desfocada:", pedalada_mouseout);
                        // 
                        let id_pedalada_mouseout = parseInt(pedalada_mouseout[2], 10);
                        //console.log("id da pedalada desfocada:", id_pedalada_mouseout);
                        // Obtendo index no array pedaldas_selected da pedalada focada
                        let index_pedalada_mouseout = pedaladas_selected.map(object => object.id).indexOf(id_pedalada_mouseout);
                        //console.log("indice da pedalada desfocada:", index_pedalada_mouseout);

                        if (index_pedalada_mouseout == 0) {
                            lineFirstOut(this, index_pedalada_mouseout, pedalada_mouseout, pedaladas_selected);
                        } else {
                            lineOthersOut(this, index_pedalada_mouseout, pedalada_mouseout, pedaladas_selected);
                        }

                    }
                }
            })
            .on('click', function() {

                if (disableClickLineFalse(this)) {

                    let pedalada_clicada = $(this).attr("id").split("_");
                    // Obtendo cores dos ciclistas dos checkbox
                    let color = $('#' + pedalada_clicada[0]).attr('style').replace(";", "").replace("background-color: ", "");
                    let color_current = '';

                    if (color == 'rgb(211, 69, 91)') {

                        //console.log("color red");
                        if (store.session.get('colors_red_current').length == 0) {
                            store.session.set('colors_red_current', store.session.get('colors_red'));
                        }
                        color_current = store.session.get('colors_red_current');

                        d3.select(this)
                            .style("stroke", color_current.pop())
                            .style("stroke-width", max_height_lens)
                            .attr("pedalada_clicada", true);
                        pedaladas_red_clicadas += 1;
                        store.session.set('colors_red_current', color_current);
                        console.log("pedaladas red clicadas:", pedaladas_red_clicadas);

                        if (pedaladas_clicadas == 1) {

                            let dad = d3.select(line.parentNode).attr("id");
                            //console.log("elemento pai:", dad);
                            //let grandFather = $(line).parent().parent().attr("id");
                            //console.log("elemento avo:", grandFather);
                            //grandFather = d3.select(grandFather.parentNode);
                            // let parent_color = d3.select(line.parentNode).attr("style")
                            //console.log("cor do pai:", parent_color);
                            let heightBox = d3.select('#' + dad).style("height");
                            heightBox = parseInt(heightBox.replace("px", ""));
                            //console.log("heightBox:", heightBox);
                            d3.select('#' + dad)
                                .style('height', ((heightBox + padding_lens_first) + 5) + 'px');

                        }
                        if (pedaladas_clicadas == 2) {

                        }
                        if (pedaladas_clicadas == 3) {

                        }

                        //console.log("cores vermelhas restantes:", store.session.get('colors_red_current'));
                    }
                    if (color == 'rgb(44, 136, 217)') {

                        //console.log("color blue");
                        if (store.session.get('colors_blue_current').length == 0) {
                            store.session.set('colors_blue_current', store.session.get('colors_blue'));
                        }
                        color_current = store.session.get('colors_blue_current');

                        d3.select(this)
                            .style("stroke", color_current.pop())
                            .style("stroke-width", max_height_lens)
                            .attr("pedalada_clicada", true);

                        pedaladas_blue_clicadas += 1;
                        store.session.set('colors_blue_current', color_current);
                        console.log("pedaladas blue clicadas:", pedaladas_blue_clicadas);
                    }
                    if (color == 'rgb(247, 195, 37)') {

                        //console.log("color yellow");
                        if (store.session.get('colors_yellow_current').length == 0) {
                            store.session.set('colors_yellow_current', store.session.get('colors_yellow'));
                        }
                        color_current = store.session.get('colors_yellow_current');

                        d3.select(this)
                            .style("stroke", color_current.pop())
                            .style("stroke-width", max_height_lens)
                            .attr("pedalada_clicada", true);
                        pedaladas_yellow_clicadas += 1;
                        store.session.set('colors_yellow_current', color_current);
                        console.log("pedaladas yellow clicadas:", pedaladas_yellow_clicadas);

                    }
                    if (color == 'rgb(47, 177, 156)') {

                        //console.log("color green");
                        if (store.session.get('colors_green_current').length == 0) {
                            store.session.set('colors_green_current', store.session.get('colors_green'));
                        }
                        color_current = store.session.get('colors_green_current');

                        d3.select(this)
                            .style("stroke", color_current.pop())
                            .style("stroke-width", max_height_lens)
                            .attr("pedalada_clicada", true);
                        pedaladas_green_clicadas += 1;
                        store.session.set('colors_green_current', color_current);
                        console.log("pedaladas green clicadas:", pedaladas_green_clicadas);

                    }
                    if (color == 'rgb(115, 15, 195)') {

                        //console.log("color purple");
                        if (store.session.get('colors_purple_current').length == 0) {
                            store.session.set('colors_purple_current', store.session.get('colors_purple'));
                        }
                        color_current = store.session.get('colors_purple_current');

                        d3.select(this)
                            .style("stroke", color_current.pop())
                            .style("stroke-width", max_height_lens)
                            .attr("pedalada_clicada", true);
                        pedaladas_purple_clicadas += 1;
                        store.session.set('colors_purple_current', color_current);
                        console.log("pedaladas purple clicadas:", pedaladas_purple_clicadas);


                    }
                } else {
                    enableClickLineTrue(this);
                }
            });

    }

    function lineStateOriginal(line, key, pedaladas_clicadas) {
        let color_current = '';
        let colors_remaining = '';
        //console.log("Desabilitando clicks no box do table lens");
        color_current = d3.select(line).style("stroke");
        //console.log("cor da linha clicada:", color_current);
        d3.select(line)
            .style("stroke", background_lens)
            .style("stroke-width", min_height_lens)
            .attr("pedalada_clicada", false);
        pedaladas_clicadas -= 1;
        colors_remaining = store.session.get(key);
        colors_remaining.push(color_current);
        store.session.set(key, colors_remaining);
        console.log(key + " clicadas:", pedaladas_clicadas);
        console.log(key + " restantes:", store.session.get(key));
        return pedaladas_clicadas;
    }

    function enableClickLineTrue(line) {

        if ($(line).attr("pedalada_clicada") == 'true') {
            console.log("Habilitando clicks no box do table lens");

            let pedalada = $(line).attr("id").split("_");
            let color = $('#' + pedalada).attr('style').replace(";", "").replace("background-color: ", "");

            if ((color == 'rgb(211, 69, 91)')) {
                pedaladas_red_clicadas = lineStateOriginal(line, 'colors_red_current', pedaladas_red_clicadas);
            }

            if ((color == 'rgb(44, 136, 217)')) {
                pedaladas_blue_clicadas = lineStateOriginal(line, 'colors_blue_current', pedaladas_blue_clicadas);
            }

            if ((color == 'rgb(247, 195, 37)')) {
                pedaladas_yellow_clicadas = lineStateOriginal(line, 'colors_yellow_current', pedaladas_yellow_clicadas);
            }

            if ((color == 'rgb(47, 177, 156)')) {
                pedaladas_green_clicadas = lineStateOriginal(line, 'colors_green_current', pedaladas_green_clicadas);
            }

            if ((color == 'rgb(115, 15, 195)')) {
                pedaladas_purple_clicadas = lineStateOriginal(line, 'colors_purple_current', pedaladas_purple_clicadas);
            }
        }

        return true;
    }

    // Desabilitando clicks nas linhas false, após selecionar três linhas
    function disableClickLineFalse(line) {

        //console.log("desabilitando clicks no box do table lens");
        let pedalada = $(line).attr("id").split("_");
        let color = $('#' + pedalada).attr('style').replace(";", "").replace("background-color: ", "");

        if (($(line).attr("pedalada_clicada") == 'false') && (color == 'rgb(211, 69, 91)') && (pedaladas_red_clicadas == 3)) {
            return false
        }

        if (($(line).attr("pedalada_clicada") == 'true') && (color == 'rgb(211, 69, 91)')) {
            return false
        }

        if (($(line).attr("pedalada_clicada") == 'false') && (color == 'rgb(44, 136, 217)') && (pedaladas_blue_clicadas == 3)) {
            return false
        }

        if (($(line).attr("pedalada_clicada") == 'true') && (color == 'rgb(44, 136, 217)')) {
            return false
        }

        if (($(line).attr("pedalada_clicada") == 'false') && (color == 'rgb(247, 195, 37)') && (pedaladas_yellow_clicadas == 3)) {
            return false
        }

        if (($(line).attr("pedalada_clicada") == 'true') && (color == 'rgb(247, 195, 37)')) {
            return false
        }

        if (($(line).attr("pedalada_clicada") == 'false') && (color == 'rgb(47, 177, 156)') && (pedaladas_green_clicadas == 3)) {
            return false
        }

        if (($(line).attr("pedalada_clicada") == 'true') && (color == 'rgb(47, 177, 156)')) {
            return false
        }

        if (($(line).attr("pedalada_clicada") == 'false') && (color == 'rgb(115, 15, 195)') && (pedaladas_purple_clicadas == 3)) {
            return false
        }

        if (($(line).attr("pedalada_clicada") == 'true') && (color == 'rgb(115, 15, 195)')) {
            return false
        }

        return true;
    }

    function disableAnimationBox(line) {
        //console.log("desabilitando Animation no box do table lens");
        let pedalada = $(line).attr("id").split("_");
        let color = $('#' + pedalada).attr('style').replace(";", "").replace("background-color: ", "");

        if ((color == 'rgb(211, 69, 91)') && (pedaladas_red_clicadas == 3)) {
            return false
        }

        if ((color == 'rgb(44, 136, 217)') && (pedaladas_blue_clicadas == 3)) {
            return false
        }

        if ((color == 'rgb(247, 195, 37)') && (pedaladas_yellow_clicadas == 3)) {
            return false
        }

        if ((color == 'rgb(47, 177, 156)') && (pedaladas_green_clicadas == 3)) {
            return false
        }

        if ((color == 'rgb(115, 15, 195)') && (pedaladas_purple_clicadas == 3)) {
            return false
        }

        return true;
    }

    function lineFirstOver(line, index_pedalada_mouseover, pedalada_mouseover, pedaladas_selected) {

        d3.select(line)
            .style("stroke", background_lens_focus)
            .style("stroke-width", max_height_lens);

        // Modificando box do table lens
        let dad = d3.select(line.parentNode).attr("id");
        //console.log("elemento pai:", dad);
        //let grandFather = $(line).parent().parent().attr("id");
        //console.log("elemento avo:", grandFather);
        //grandFather = d3.select(grandFather.parentNode);
        // let parent_color = d3.select(line.parentNode).attr("style")
        //console.log("cor do pai:", parent_color);
        let heightBox = d3.select('#' + dad).style("height");
        heightBox = parseInt(heightBox.replace("px", ""));
        //console.log("heightBox:", heightBox);
        d3.select('#' + dad)
            .style('height', ((heightBox + padding_lens_first) + 5) + 'px');

        // let topBox = d3.select('#' + grandFather).style("top")
        // topBox = parseInt(topBox.replace("px", ""));
        // //console.log(topBox);
        // d3.select('#' + grandFather)
        //     .style('top', (topBox - 5) + 'px');

        // Modificando as linhas
        for (let firstOver_id_pedalada = 0; firstOver_id_pedalada < pedaladas_selected.length; firstOver_id_pedalada++) {

            // Obtendo linha a ser modificada
            if (firstOver_id_pedalada == index_pedalada_mouseover) {
                let index_pedalada_modified = pedaladas_selected[firstOver_id_pedalada].id;
                let line_modified = '#' + pedalada_mouseover[0] + "_" + pedalada_mouseover[1] + "_" + index_pedalada_modified;
                //console.log("linha a ser modificada", line_modified);

                // Obtendo posição numérica de y da linha a ser modificada
                // usando parseInt para converter para número na base da 10
                let y_pos = parseInt($(line_modified).attr("y1"), 10);
                //console.log("posição de y", y_pos);
                d3.select(line_modified)
                    .attr("y1", y_pos + padding_lens_first)
                    .attr("y2", y_pos + padding_lens_first);
            }

            if (firstOver_id_pedalada > index_pedalada_mouseover) {
                let index_pedalada_modified = pedaladas_selected[firstOver_id_pedalada].id;
                let line_modified = '#' + pedalada_mouseover[0] + "_" + pedalada_mouseover[1] + "_" + index_pedalada_modified;
                //console.log("linha a ser modificada", line_modified);

                // Obtendo posição numérica de y da linha a ser modificada
                // usando parseInt para converter para número na base da 10
                let y_pos = parseInt($(line_modified).attr("y1"), 10);
                //console.log("posição de y", y_pos);
                d3.select(line_modified)
                    .attr("y1", (y_pos + padding_lens_first) + 5)
                    .attr("y2", (y_pos + padding_lens_first) + 5);
            }

        }

    }

    function lineOthersOver(line, index_pedalada_mouseover, pedalada_mouseover, pedaladas_selected) {

        d3.select(line)
            .style("stroke", background_lens_focus)
            .style("stroke-width", max_height_lens);

        // Modificando box do table lens
        let dad = d3.select(line.parentNode).attr("id");
        //console.log("elemento pai:", dad);
        //let grandFather = $(line).parent().parent().attr("id");
        //console.log("elemento avo:", grandFather);
        //grandFather = d3.select(grandFather.parentNode);
        // let parent_color = d3.select(line.parentNode).attr("style")
        //console.log("cor do pai:", parent_color);
        let heightBox = d3.select('#' + dad).style("height");
        heightBox = parseInt(heightBox.replace("px", ""));
        //console.log("heightBox:", heightBox);
        d3.select('#' + dad)
            .style('height', (heightBox + padding_lens_first) + 'px');

        // let topBox = d3.select('#' + grandFather).style("top")
        // topBox = parseInt(topBox.replace("px", ""));
        // //console.log(topBox);
        // d3.select('#' + grandFather)
        //     .style('top', ((topBox - padding_lens_first)) + 'px');

        // Modificando as linhas
        for (let id_pedalada = 0; id_pedalada < pedaladas_selected.length; id_pedalada++) {

            // Obtendo linhas a serem modificadas
            // linhas acima da linha focada
            if (id_pedalada < index_pedalada_mouseover) {
                let index_pedalada_modified = pedaladas_selected[id_pedalada].id;
                let line_modified = '#' + pedalada_mouseover[0] + "_" + pedalada_mouseover[1] + "_" + index_pedalada_modified;
                //console.log("linha a ser modificada", line_modified);

                // Obtendo posição numérica de y da linha a ser modificada
                // usando parseInt para converter para número na base da 10
                let y_pos = parseInt($(line_modified).attr("y1"), 10);
                //console.log("posição de y", y_pos);
                d3.select(line_modified)
                    .attr("y1", y_pos - padding_lens_first)
                    .attr("y2", y_pos - padding_lens_first);
            }
            // linhas abaixo da linha focada
            if (id_pedalada > index_pedalada_mouseover) {
                let index_pedalada_modified = pedaladas_selected[id_pedalada].id;
                let line_modified = '#' + pedalada_mouseover[0] + "_" + pedalada_mouseover[1] + "_" + index_pedalada_modified;
                //console.log("linha a ser modificada", line_modified);

                // Obtendo posição numérica de y da linha a ser modificada
                // usando parseInt para converter para número na base da 10
                let y_pos = parseInt($(line_modified).attr("y1"), 10);
                //console.log("posição de y", y_pos);
                d3.select(line_modified)
                    .attr("y1", y_pos + padding_lens_first)
                    .attr("y2", y_pos + padding_lens_first);
            }

        }

    }

    function lineFirstOut(line, index_pedalada_mouseout, pedalada_mouseout, pedaladas_selected) {

        d3.select(line)
            .style("stroke", background_lens)
            .style("stroke-width", min_height_lens);

        // Modificando box do table lens
        let dad = d3.select(line.parentNode).attr("id");
        //console.log("elemento pai:", parent);
        //let grandFather = $(line).parent().parent().attr("id");
        //console.log("elemento avo:", grandFather);
        //grandFather = d3.select(grandFather.parentNode);
        // let parent_color = d3.select(line.parentNode).attr("style")
        //console.log("cor do pai:", parent_color);
        let heightBox = d3.select('#' + dad).style("height");
        heightBox = parseInt(heightBox.replace("px", ""));
        //console.log("heightBox:", heightBox);
        d3.select('#' + dad)
            .style('height', ((heightBox - padding_lens_first) - 5) + 'px');

        // let topBox = d3.select('#' + grandFather).style("top")
        // topBox = parseInt(topBox.replace("px", ""));
        // //console.log(topBox);
        // d3.select('#' + grandFather)
        //     .style('top', (topBox + 5) + 'px');

        // Modificando as linhas
        for (let firstOut_id_pedalada = 0; firstOut_id_pedalada < pedaladas_selected.length; firstOut_id_pedalada++) {

            // Obtendo linha a ser modificada
            if (firstOut_id_pedalada == index_pedalada_mouseout) {
                let index_pedalada_modified = pedaladas_selected[firstOut_id_pedalada].id;
                let line_modified = '#' + pedalada_mouseout[0] + "_" + pedalada_mouseout[1] + "_" + index_pedalada_modified;
                //console.log("linha a ser modificada", line_modified);

                // Obtendo posição numérica de y da linha a ser modificada
                // usando parseInt para converter para número na base da 10
                let y_pos = parseInt($(line_modified).attr("y1"), 10);
                //console.log("posição de y", y_pos);
                d3.select(line_modified)
                    .attr("y1", y_pos - padding_lens_first)
                    .attr("y2", y_pos - padding_lens_first);
            }

            if (firstOut_id_pedalada > index_pedalada_mouseout) {
                let index_pedalada_modified = pedaladas_selected[firstOut_id_pedalada].id;
                let line_modified = '#' + pedalada_mouseout[0] + "_" + pedalada_mouseout[1] + "_" + index_pedalada_modified;
                //console.log("linha a ser modificada", line_modified);

                // Obtendo posição numérica de y da linha a ser modificada
                // usando parseInt para converter para número na base da 10
                let y_pos = parseInt($(line_modified).attr("y1"), 10);
                //console.log("posição de y", y_pos);
                d3.select(line_modified)
                    .attr("y1", (y_pos - padding_lens_first) - 5)
                    .attr("y2", (y_pos - padding_lens_first) - 5);
            }

        }

    }

    function lineOthersOut(line, index_pedalada_mouseout, pedalada_mouseout, pedaladas_selected) {

        d3.select(line)
            .style("stroke", background_lens)
            .style("stroke-width", min_height_lens);

        // Modificando box do table lens
        let dad = d3.select(line.parentNode).attr("id");
        //console.log("elemento pai:", dad);
        //let grandFather = $(line).parent().parent().attr("id");
        //console.log("elemento avo:", grandFather);
        //grandFather = d3.select(grandFather.parentNode);
        // let parent_color = d3.select(line.parentNode).attr("style")
        //console.log("cor do pai:", parent_color);
        let heightBox = d3.select('#' + dad).style("height");
        heightBox = parseInt(heightBox.replace("px", ""));
        //console.log("heightBox:", heightBox);
        d3.select('#' + dad)
            .style('height', (heightBox - padding_lens_first) + 'px');

        // let topBox = d3.select('#' + grandFather).style("top")
        // topBox = parseInt(topBox.replace("px", ""));
        // //console.log(topBox);
        // d3.select('#' + grandFather)
        //     .style('top', (topBox + padding_lens_first) + 'px');

        // Modificando as linhas
        for (let id_pedalada = 0; id_pedalada < pedaladas_selected.length; id_pedalada++) {

            // Obtendo linhas a serem modificada
            // linhas acima da linha focada
            if (id_pedalada < index_pedalada_mouseout) {
                let index_pedalada_modified = pedaladas_selected[id_pedalada].id;
                let line_modified = '#' + pedalada_mouseout[0] + "_" + pedalada_mouseout[1] + "_" + index_pedalada_modified;
                //console.log("linha a ser modificada", line_modified);

                // Obtendo posição numérica de y da linha a ser modificada
                // usando parseInt para converter para número na base da 10
                let y_pos = parseInt($(line_modified).attr("y1"), 10);
                //console.log("posição de y", y_pos);
                d3.select(line_modified)
                    .attr("y1", y_pos + padding_lens_first)
                    .attr("y2", y_pos + padding_lens_first);
            }

            // Linhas abaixo da linha focada
            if (id_pedalada > index_pedalada_mouseout) {
                let index_pedalada_modified = pedaladas_selected[id_pedalada].id;
                let line_modified = '#' + pedalada_mouseout[0] + "_" + pedalada_mouseout[1] + "_" + index_pedalada_modified;
                //console.log("linha a ser modificada", line_modified);

                // Obtendo posição numérica de y da linha a ser modificada
                // usando parseInt para converter para número na base da 10
                let y_pos = parseInt($(line_modified).attr("y1"), 10);
                //console.log("posição de y", y_pos);
                d3.select(line_modified)
                    .attr("y1", y_pos - padding_lens_first)
                    .attr("y2", y_pos - padding_lens_first);
            }

        }

    }
</script>