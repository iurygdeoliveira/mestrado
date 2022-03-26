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
                                                <div class="progress-bar" id='<?= 'progress_bar_' . $this->e($rider->name) ?>' role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-grid">
                                                <button type="button" class="btn btn-primary" id='<?= 'button_carregar_' . $this->e($rider->name) ?>' onclick="saveData('<?= $this->e($rider->name) ?>', '<?= $this->e($rider->dataset) ?>', '<?= $this->e($rider->atividade) ?>','<?= $this->e($url) ?>')">Carregar Dados</button>
                                            </div>
                                            <div class="d-grid">
                                                <button class="btn btn-primary" type="button" id='<?= 'button_loading_' . $this->e($rider->name) ?>' style="display: none;">
                                                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                                    Loading...
                                                </button>
                                            </div>
                                            <div class="d-grid">
                                                <button type="button" id='<?= 'button_success_' . $this->e($rider->name) ?>' class="btn btn-success" style="display: none;">Sucesso</button>
                                            </div>
                                            <div class="d-grid">
                                                <button type="button" id='<?= 'button_danger_' . $this->e($rider->name) ?>' class="btn btn-danger" style="display: none;">Erro</button>
                                            </div>
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