<script>
    function animationTableLens() {

        let lines = d3.selectAll("div[line_clicked]")
            .on('mouseover', function() {

                // Habilitar animação apenas nas pedaladas não clicadas
                if (disableAnimationBox(this)) {

                    if ((d3.select(this).attr("line_clicked") == 'false')) {

                        lineOver('#' + d3.select(this).attr("id"));

                    }
                }

            })
            .on('mouseout', function() {

                if (disableAnimationBox(this)) {

                    if (d3.select(this).attr("line_clicked") == 'false') {

                        lineOut('#' + d3.select(this).attr("id"));

                    }
                }
            })
            .on('click', function() {

                // Desabilitar click nas linhas falsas para travar animação
                if (disableClickLineFalse(this)) {

                    //let pedalada_clicada = d3.select(this).attr("id").split("_");
                    // Obtendo cores dos ciclistas dos checkbox
                    let color_main = $(this).parent().css('border-top-color');
                    let color_current = '';

                    switch (color_main) {
                        case normalRed:
                            lineClicked(this, 'colors_red_current', 'colors_red');
                            pedaladas_red_clicadas += 1;
                            console.log("pedaladas red clicadas:", pedaladas_red_clicadas);
                            break;
                        case normalBlue:
                            lineClicked(this, 'colors_blue_current', 'colors_blue');
                            pedaladas_blue_clicadas += 1;
                            console.log("pedaladas blue clicadas:", pedaladas_blue_clicadas);
                            break;
                        case normalYellow:
                            lineClicked(this, 'colors_yellow_current', 'colors_yellow');
                            pedaladas_yellow_clicadas += 1;
                            console.log("pedaladas yellow clicadas:", pedaladas_yellow_clicadas);
                            break;
                        case normalGreen:
                            lineClicked(this, 'colors_green_current', 'colors_green');
                            pedaladas_green_clicadas += 1;
                            console.log("pedaladas green clicadas:", pedaladas_green_clicadas);
                            break;
                        case normalPurple:
                            lineClicked(this, 'colors_purple_current', 'colors_purple');
                            pedaladas_purple_clicadas += 1;
                            console.log("pedaladas purple clicadas:", pedaladas_purple_clicadas);
                            break;
                    }
                } else {
                    enableClickLineTrue(this);
                }

            });

    }

    function lineClicked(pedalada, colors_current, colors) {
        let aux = [];

        //console.log("color red");
        if (store.session.get(colors_current).length == 0) {
            store.session.set(colors_current, store.session.get(colors));
        }
        aux = store.session.get(colors_current); // Obtendo cores a serem utilizadas 
        color_current = aux.pop(); // Obtendo cor específica a ser utilizada

        lineStateChange(pedalada, color_current);

        store.session.set(colors_current, aux);

        // Armazenando as pedaladas para o bar chart
        push_pedaladas_barChart(pedalada);
    }

    function lineStateChange(line, color_current) {
        changeColorLine('#' + $(line).attr("id"), color_current);
        d3.select(line)
            .attr("line_clicked", 'true')
            .attr("color_selected", color_current);
    }

    function lineStateOriginal(line, key, pedaladas_clicadas) {
        let color_current = '';
        let colors_remaining = '';
        //console.log("Desabilitando clicks no box do table lens");
        color_current = d3.select(line).attr("color_selected");

        changeColorLine('#' + $(line).attr("id"), background_lens);
        d3.select(line)
            .attr("line_clicked", 'false')
            .attr("color_selected", 'false');
        adjustHeightLine('#' + $(line).attr("id"));
        pedaladas_clicadas -= 1;
        remove_pedaladas_barChart(line); // Removendo pedalada do barchart
        colors_remaining = store.session.get(key);
        colors_remaining.push(color_current);
        store.session.set(key, colors_remaining);
        console.log(key + " clicadas:", pedaladas_clicadas);
        console.log(key + " restantes:", store.session.get(key));
        return pedaladas_clicadas;
    }

    function enableClickLineTrue(line) {

        if ($(line).attr("line_clicked") == 'true') {
            console.log("Habilitando clicks no box do table lens");

            let pedalada = $(line).attr("id").split("_");
            let color = $('#' + pedalada).attr('style').replace(";", "").replace("background-color: ", "");

            if ((color == normalRed)) {
                pedaladas_red_clicadas = lineStateOriginal(line, 'colors_red_current', pedaladas_red_clicadas);
            }

            if ((color == normalBlue)) {
                pedaladas_blue_clicadas = lineStateOriginal(line, 'colors_blue_current', pedaladas_blue_clicadas);
            }

            if ((color == normalYellow)) {
                pedaladas_yellow_clicadas = lineStateOriginal(line, 'colors_yellow_current', pedaladas_yellow_clicadas);
            }

            if ((color == normalGreen)) {
                pedaladas_green_clicadas = lineStateOriginal(line, 'colors_green_current', pedaladas_green_clicadas);
            }

            if ((color == normalPurple)) {
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

        if (($(line).attr("line_clicked") == 'false') && (color == normalRed) && (pedaladas_red_clicadas == 3)) {
            return false
        }

        if (($(line).attr("line_clicked") == 'true') && (color == normalRed)) {
            return false
        }

        if (($(line).attr("line_clicked") == 'false') && (color == normalBlue) && (pedaladas_blue_clicadas == 3)) {
            return false
        }

        if (($(line).attr("line_clicked") == 'true') && (color == normalBlue)) {
            return false
        }

        if (($(line).attr("line_clicked") == 'false') && (color == normalYellow) && (pedaladas_yellow_clicadas == 3)) {
            return false
        }

        if (($(line).attr("line_clicked") == 'true') && (color == normalYellow)) {
            return false
        }

        if (($(line).attr("line_clicked") == 'false') && (color == normalGreen) && (pedaladas_green_clicadas == 3)) {
            return false
        }

        if (($(line).attr("line_clicked") == 'true') && (color == normalGreen)) {
            return false
        }

        if (($(line).attr("line_clicked") == 'false') && (color == normalPurple) && (pedaladas_purple_clicadas == 3)) {
            return false
        }

        if (($(line).attr("line_clicked") == 'true') && (color == normalPurple)) {
            return false
        }

        return true;
    }

    function disableAnimationBox(line) {
        //console.log("desabilitando Animation no box do table lens");
        let pedalada = $(line).attr("id").split("_");
        let color = $('#' + pedalada).attr('style').replace(";", "").replace("background-color: ", "");

        if ((color == normalRed) && (pedaladas_red_clicadas == 3)) {
            return false
        }

        if ((color == normalBlue) && (pedaladas_blue_clicadas == 3)) {
            return false
        }

        if ((color == normalBlue) && (pedaladas_yellow_clicadas == 3)) {
            return false
        }

        if ((color == normalGreen) && (pedaladas_green_clicadas == 3)) {
            return false
        }

        if ((color == normalPurple) && (pedaladas_purple_clicadas == 3)) {
            return false
        }

        return true;
    }

    function changeColorLine(line, color) {
        d3.select(line)
            .style('background-color', color)
            .style('border', '0.1px solid ' + color);
    }

    function adjustHeightBox(line, over) {

        if (switchToggle == 'overview') {
            let parent = '#' + $(line).parent().attr('id');
            //console.log(parent);
            let height_box = parseInt(d3.select(parent).style('height').replace('px', ''));
            if (over) {
                d3.select(parent).style('height', ((height_box + 15) + 'px'));
            } else {
                d3.select(parent).style('height', ((height_box - 15) + 'px'));
            }
        }
    }

    function lineOver(line) {
        changeColorLine(line, background_lens_focus);
        applyHeightItem(line);
        adjustHeightBox(line, true);
    }

    function lineOut(line) {
        changeColorLine(line, background_lens);
        adjustHeightLine(line);
        adjustHeightBox(line, false);

    }
</script>