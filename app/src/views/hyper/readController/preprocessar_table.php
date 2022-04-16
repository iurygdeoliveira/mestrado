 <?php foreach ($riders as $rider) : ?>
     <table class="table table-hover table-centered mb-0 mt-2 border-primary border">
         <thead>
             <tr>
                 <th class=' text-center col-1'>Ciclista
                     <div>
                         <a href="#" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" title='<?= $this->e($rider->dataset) ?>'> <?= $this->e($rider->name) ?>
                         </a>
                     </div>
                 </th>
                 <th class='text-center col-2'>Extraindo atividade:
                     <div id='<?= 'activity_extract_' . $this->e($rider->name) ?>'>0</div>
                 </th>
                 <th class='text-center col-6'>Status:
                     <span class="progress">
                         <div class="progress-bar" id='<?= 'progress_bar_' . $this->e($rider->name) ?>' role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                     </span>
                 </th>
                 <th class='text-center col-3'>

                     <div class="d-grid">
                         <button type="button" class="btn btn-primary" id='<?= 'button_carregar_' . $this->e($rider->name) ?>' onclick="preprocessar('<?= $this->e($rider->name) ?>', '<?= $this->e($rider->dataset) ?>', '<?= $this->e($rider->atividade) ?>','<?= $this->e($url) ?>')">Extrair estrutura de nós</button>
                     </div>
                     <div class="d-grid">
                         <button class="btn btn-primary" type="button" id='<?= 'button_loading_' . $this->e($rider->name) ?>' style="display: none;" disabled>
                             <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                             Extraindo ...
                         </button>
                     </div>
                     <div class="d-grid">
                         <button type="button" id='<?= 'button_success_' . $this->e($rider->name) ?>' class="btn btn-success" style="display: none;" onclick="getNodes('<?= $this->e($rider->name) ?>', '<?= $this->e($rider->dataset) ?>', '<?= $this->e($rider->atividade) ?>','<?= $this->e($url) ?>')">Obter possíveis informações</button>
                     </div>
                     <div class="d-grid">
                         <button type="button" id='<?= 'button_danger_' . $this->e($rider->name) ?>' class="btn btn-danger" style="display: none;" onclick="preprocessar('<?= $this->e($rider->name) ?>', '<?= $this->e($rider->dataset) ?>', '<?= $this->e($rider->atividade) ?>','<?= $this->e($url) ?>')">Erro (Tentar novamente) </button>
                     </div>

                 </th>
             </tr>
         </thead>
         <tbody>
             <tr>
                 <td colspan="4" class="col-6">
                     <div class="card m-0">
                         <div class="card-body">
                             <h5 class="card-title text-danger">Erro </h5>
                             <p class="card-text" id='<?= 'error_extract_' . $this->e($rider->name) ?>'>
                                 Sem erros
                             </p>
                         </div> <!-- end card-body-->
                     </div> <!-- end card-->
                 </td>
             </tr>
         </tbody>
     </table>
 <?php endforeach; ?>