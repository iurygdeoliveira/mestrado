 <script>
     async function maxIntensity(pedaladas) {

         let value = 0;
         let maxIntensity;
         for (let index = 0; index < pedaladas.length; index++) {

             if (pedaladas[index].intensity.length > value) {
                 value = pedaladas[index].intensity.length;
                 maxIntensity = index;
             }
         }

         return maxIntensity

     }

     async function mountMatrixData(pedaladas) {


         let max = await maxIntensity(pedaladas);
         let data = []; // Inicializa array vazio

         for (let i = 0; i < pedaladas.length; i++) { // Itera o numero total de pedaladas
             for (let j = 0; j < pedaladas[max].intensity.length; j++) { // Itera o número de vezes da maior itensidade

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
         let max = await maxIntensity(pedaladas_barChart);
         const labelXAxis = await mountLabelxAxis(pedaladas_barChart[max].intensity);
         const labelYAxis = await mountLabelyAxis(pedaladas_barChart);

         // prettier-ignore
         const data = await mountIntensityData(pedaladas_barChart);

         option = {
             title: {
                 show: true,
                 text: "Intensity",
                 textStyle: {
                     fontSize: 12
                 }
             },
             tooltip: {
                 position: "top",
             },
             grid: {
                 height: "75%",
                 top: "15%",
             },
             xAxis: {
                 type: "category",
                 data: labelXAxis,
                 splitArea: {
                     show: false,
                 },
                 name: 'm',
                 nameLocation: 'start'
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
                 }
             },
             toolbox: {
                 show: true,
                 feature: {
                     dataView: {
                         readOnly: false
                     },
                     restore: {},
                     saveAsImage: {}
                 }
             },
             dataZoom: [{
                 type: 'slider',
                 startValue: 0,
                 top: 25,
                 height: 25,
                 minValueSpan: viewStream
             }],
             visualMap: {
                 type: 'continuous',
                 range: [0, 1],
                 inRange: {
                     color: colorHeatmap
                 },
                 min: 0,
                 max: 1,
                 calculable: true,
                 realtime: false,
                 orient: 'vertical',
                 precision: 1,
                 top: 'middle',
                 align: 'left',
                 right: '1'
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
                 progressive: 1000,
                 animation: false
             }, ],
         };

         option && await myChart.setOption(option);

         return myChart
     }

     async function updateHeatmapChart() {

         console.log("Update HeatMapChart ...");
         await resizeHeatMapChart();
         return await create_HeatMapChart();

     }
 </script>