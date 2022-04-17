 <?php foreach ($riders as $rider) : ?>

     <div class="col-12" id='<?= 'diffvis_' . $this->e($rider->name) ?>' style="display: none;">
         <div class="card border-primary border">
             <div class="card-body">
                 <h5 class="card-title text-primary">Ciclista <?= $this->e($rider->name) ?></h5>
                 <div style="height:200px" id='<?= 'mapvis_' . $this->e($rider->name) ?>'></div>
             </div>
             <!-- end card body-->
         </div>
         <!-- end card -->
     </div>
     <!-- end col-->

 <?php endforeach; ?>