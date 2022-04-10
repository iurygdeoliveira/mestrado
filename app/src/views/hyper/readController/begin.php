<!-- Begin page -->
<div class="wrapper">

    <?php $this->insert("../leftsidebar/leftsidebar") ?>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <?php $this->insert("../topbar/topbar") ?>

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title"> Extrair dados dos arquivos GPX e TCX </h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="col-12">
                    <div class="card border-primary border">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Resumo Geral dos Dados</h5>
                            <p class="card-text"><?php $this->insert("metaData") ?></p>
                            <h5 class="card-title text-danger">Erro </h5>
                            <p class="card-text" id='error_extract'>
                                Sem erros
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div>

                <table class="table table-hover table-centered mb-0 border-primary border">
                    <thead>
                        <tr>
                            <th class='col-1 text-center'>Ciclista</th>
                            <th class='col-2 text-center'>Total de Atividades</th>
                            <th class='col-5 text-center'>Status</th>
                            <th class='col-2 text-center'>Tempo Gasto (seg)</th>
                            <th class='col-2 text-center'>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riders as $rider) : ?>
                            <tr>
                                <td class='col-1 text-center'>
                                    <a href="#" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" title='<?= $this->e($rider->dataset) ?>'>
                                        <?= $this->e($rider->name) ?>
                                    </a>
                                </td>
                                <td class='col-2 text-center' id='<?= 'rider_' . $this->e($rider->name) . '_activity' ?>'>
                                    <?= $this->e($rider->atividade) ?>
                                </td>
                                <td>
                                    <span class="progress">
                                        <div class="progress-bar" id='<?= 'progress_bar_' . $this->e($rider->name) ?>' role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                    </span>
                                </td>
                                <td id='<?= 'time_extract_' . $this->e($rider->name) ?>'>

                                </td>
                                <td class='col-4'>
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-primary" id='<?= 'button_carregar_' . $this->e($rider->name) ?>' onclick="extractActivities('<?= $this->e($rider->name) ?>', '<?= $this->e($rider->dataset) ?>', '<?= $this->e($rider->atividade) ?>','<?= $this->e($url) ?>')">Extrair Dados</button>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="button" id='<?= 'button_loading_' . $this->e($rider->name) ?>' style="display: none;">
                                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                            Extraindo...
                                        </button>
                                    </div>
                                    <div class="d-grid">
                                        <button type="button" id='<?= 'button_success_' . $this->e($rider->name) ?>' class="btn btn-success" style="display: none;">Sucesso</button>
                                    </div>
                                    <div class="d-grid">
                                        <button type="button" id='<?= 'button_danger_' . $this->e($rider->name) ?>' class="btn btn-danger" style="display: none;" onclick="extractActivities('<?= $this->e($rider->name) ?>', '<?= $this->e($rider->dataset) ?>', '<?= $this->e($rider->atividade) ?>','<?= $this->e($url) ?>')">Erro (Tentar novamente) </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

        </div> <!-- end container -->

    </div> <!-- end content -->


    <?php $this->insert("../footer/footer") ?>

</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->


</div>
<!-- END wrapper -->