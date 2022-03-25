<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="tab-content">
                    <div class="tab-pane show active" id="buttons-table-preview">
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Ciclista</th>
                                    <th>Dataset</th>
                                    <th>Total de Atividades</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php foreach ($riders as $rider) : ?>
                                    <tr>
                                        <td><?= $this->e($rider->name) ?></td>
                                        <td><?= $this->e($rider->dataset) ?></td>
                                        <td><?= $this->e($rider->atividade) ?></td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary" onclick="saveData('<?= $this->e($rider->name) ?>', '<?= $this->e($rider->dataset) ?>', '<?= $this->e($rider->atividade) ?>','<?= $this->e($url) ?>')">Carregar Dados</button>
                                            <!-- <button class="btn btn-primary" type="button" disabled>
                                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                                Loading...
                                            </button> -->
                                            <!-- <button type="button" class="btn btn-success">Success</button> -->
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div> <!-- end preview-->
                </div> <!-- end tab-content-->

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<?php $this->insert("modal-processando") ?>
<?php $this->insert("modal-success") ?>
<?php $this->insert("modal-danger") ?>