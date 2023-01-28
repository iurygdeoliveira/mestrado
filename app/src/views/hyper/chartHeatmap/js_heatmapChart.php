 <script>
     async function mountMatrixData(pedaladas) {

         let data = []; // Inicializa array vazio

         for (let i = 0; i < pedaladas.length; i++) { // Itera o numero total de pedaladas
             for (let j = 0; j < pedaladas[0].intensity.length; j++) { // Itera o número de vezes da maior itensidade

                 let valor = (
                     Number.isFinite(pedaladas[i].intensity[j]) ? pedaladas[i].intensity[j] : ''
                 );
                 // insere o valor de intensidade
                 data.push([i, j, valor]); // Adiciona sub-array com i, j e valor ao array data
             }
         }

         return data;
     }

     async function mountIntensityData(pedaladas) {

         let matrix = await mountMatrixData(pedaladas);

         const data = matrix.map(function(item) {
             return [item[1], item[0], (item[2] == '' ? '-' : item[2])]
         });

         return data;
     }

     async function mountLabelyAxis(pedaladas) {

         let label = [];
         pedaladas.forEach(element => {
             label.push(element.color_selected);
         });

         return label;
     }

     async function mountLabelxAxis(maxIntensity) {

         let label = [];
         let value = 0;
         maxIntensity.forEach(element => {
             label.push(value);
             value += 100;
         });

         return label;
     }

     async function removeHeatMapChart() {
         d3.select('#pedaladas_heatmapChart').remove();
     }

     async function resizeHeatMapChart() {
         let heightHeatMapChart = parseInt(heightWindow / 2) - adjustHeightCharts;
         removeHeatMapChart();
         d3.select('#heatmapChart')
             .append('div')
             .attr("id", 'pedaladas_heatmapChart')
             .style("height", heightHeatMapChart + 'px');
     }

     async function create_HeatMapChart() {

         var chartDom = document.getElementById('pedaladas_heatmapChart');
         var myChart = await echarts.init(chartDom, null, {
             renderer: 'svg'
         });
         var option;

         // prettier-ignore
         const labelXAxis = await mountLabelxAxis(pedaladas_barChart[0].intensity);
         const labelYAxis = await mountLabelyAxis(pedaladas_barChart);

         console.log(labelXAxis, labelYAxis);

         // prettier-ignore
         const data = await mountIntensityData(pedaladas_barChart);
         console.log(data);

         option = {
             tooltip: {
                 position: "top",
             },
             grid: {
                 height: "80%",
                 top: "1%",
             },
             xAxis: {
                 type: "category",
                 data: labelXAxis,
                 splitArea: {
                     show: false,
                 },
             },
             yAxis: {
                 type: "category",
                 data: labelYAxis,
                 axisLabel: {
                     formatter: "◼",
                     fontSize: 15,
                     textStyle: {
                         backgroundColor: "white",
                         color: function(value, index) {
                             return value;
                         },
                     },
                 },
                 splitArea: {
                     show: true,
                 },
             },
             visualMap: {
                 min: 0,
                 max: 1,
                 calculable: true,
                 orient: "horizontal",
                 left: "center",
                 bottom: "1%",
                 inRange: {
                     color: colorHeatmap,
                 },
             },
             series: [{
                 name: "Intensity",
                 type: "heatmap",
                 data: data,
                 label: {
                     show: false,
                 },
                 itemStyle: {
                     color: "#fff",
                 },
                 emphasis: {
                     itemStyle: {
                         shadowBlur: 10,
                         shadowColor: "rgba(0, 0, 0, 0.5)",
                     },
                 },
             }, ],
         };

         option && myChart.setOption(option);
     }

     async function updateHeatmapChart() {

         console.log("Update HeatMapChart ...");
         await resizeHeatMapChart();
         await create_HeatMapChart();

     }
 </script>