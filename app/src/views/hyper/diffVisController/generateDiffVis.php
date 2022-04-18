 <?php foreach ($riders as $rider) : ?>

     <div class="col-12" id='<?= 'diffvis_' . $this->e($rider->name) ?>' style="display: none;">
         <div class="card border-primary border">
             <div class="card-body text-center">
                 <h5 class="card-title text-primary m-4" style="display: inline;">Ciclista <?= $this->e($rider->name) ?></h5>
                 <button type="button" class="btn btn-primary" style="display: inline;" id='saveAsPDF' onclick="savePDF()">Salvar como PDF</button>
                 <button type="button" class="btn btn-primary" style="display: inline;" id='saveAsPNG' onclick="savePNG()">Salvar como PNG</button>
                 <button type="button" class="btn btn-primary" style="display: inline;" id='saveAsCSV' onclick="saveCSV()">Salvar como CSV</button>
                 <button type="button" class="btn btn-primary" style="display: inline;" id='saveAsJSON' onclick="saveJSON()">Salvar como JSON</button>
                 <div class="col-12">
                     <div class="card border-primary border mt-3">
                         <div class="card-body">
                             <h5 class="card-title text-center text-primary">Estatísticas</h5>
                             <p class="card-text">
                             <table class="table table-hover table-centered mb-0">
                                 <thead>
                                     <tr>
                                         <th class="text-start col-3">Total de Atividades</th>
                                         <th class="text-start col-3">Quantidade de Subsets</th>
                                         <th class="text-start col-6">Informações Disponíveis</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <tr>
                                         <td class="text-start col-3"> 750</td>
                                         <td class="text-start col-3"> 4 </td>
                                         <td class="text-start col-6">
                                             Subset 1: oiweu, owqieur <br>
                                             Subset 2: oiweu, owqieur <br>
                                             Subset 3: oiweu, owqieur <br>
                                             Subset 4: oiweu, owqieur <br>
                                         </td>
                                     </tr>
                                 </tbody>
                             </table>
                             </p>
                         </div> <!-- end card-body-->
                     </div> <!-- end card-->
                 </div>
                 <div style="height:200px" id='<?= 'mapvis_' . $this->e($rider->name) ?>'></div>
             </div>
             <!-- end card body-->
         </div>
         <!-- end card -->
     </div>
     <!-- end col-->

 <?php endforeach; ?>