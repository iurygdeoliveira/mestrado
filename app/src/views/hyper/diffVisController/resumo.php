 <div class="col-12">
     <div class="card border-primary border">
         <div class="card-body">
             <h5 class="card-title text-center text-primary">Resumo Geral</h5>
             <p class="card-text">
             <table class="table table-hover table-centered mb-0">
                 <thead>
                     <tr>
                         <th class="text-center">Total de Ciclistas</th>
                         <th class="text-center">Total de Atividades</th>
                         <th class="text-center">Total de Datasets</th>
                         <th class="text-center">Data e Hora</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td class="text-center"><?= $this->e($totalCiclistas) ?></td>
                         <td class="text-center"><?= $this->e($totalAtividades) ?></td>
                         <td class="text-center"><?= $this->e($totalDatasets) ?></td>
                         <td class="text-center" id="datetime_extract"> <?= (new DateTime())->format(CONF_DATE_APP) ?></td>
                     </tr>
                     <tr>
                         <td class=' text-center col-3'>
                             <button type="button" id='button_generate_vis' class="btn btn-primary" onclick="getDataDiffVis('<?= $this->e($url) ?>', '<?= $this->e($totalCiclistas) ?>')">Gerar Visualização</button>
                             <button type="button" id='button_loading_vis' class="btn btn-primary" style="display: none;" disabled>
                                 <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                 Gerando ...
                             </button>
                             <button type="button" id='button_success_vis' class="btn btn-success" style="display: none;" disabled>Concluido !</button>
                             <button type="button" id='button_danger_vis' class="btn btn-danger" style="display: none;" onclick="getDataDiffVis('<?= $this->e($url) ?>', '<?= $this->e($totalCiclistas) ?>')">Erro (Tentar novamente) </button>

                         </td>

                         <td colspan="3" class='text-center'>Status:
                             <span class="progress">
                                 <div class="progress-bar" id='progress_bar_vis' role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                             </span>
                         </td>
                     </tr>
                     <tr>
                         <td class=' text-center col-3'>
                             <button type="button" class="btn btn-primary" id='button_generate_stats' onclick="generateStats('<?= $this->e($url_stats) ?>')" disable>Gerar Estatísticas</button>
                             <button class="btn btn-primary" type="button" id='button_loading_stats' style="display: none;" disabled>
                                 <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                 Gerando ...
                             </button>
                             <button type="button" id='button_success_stats' class="btn btn-success" style="display: none;" disabled>Concluido !</button>
                             <button type="button" id='button_danger_stats' class="btn btn-danger" style="display: none;" onclick="generateStats('<?= $this->e($url_stats) ?>')">Erro (Tentar novamente) </button>
                         </td>

                         <td colspan="3" class='text-center'>Status:
                             <span class="progress">
                                 <div class="progress-bar" id='progress_bar_stats' role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                             </span>
                         </td>
                     </tr>
                     <tr>
                         <td colspan="4" class="col-12">
                             <h5 class=" card-title text-danger mt-3">Erro</h5>
                             <p class="card-text" id='error_extract'>
                                 Sem erros
                             </p>
                         </td>
                     </tr>
                 </tbody>
             </table>
             </p>

         </div> <!-- end card-body-->
     </div> <!-- end card-->
 </div>