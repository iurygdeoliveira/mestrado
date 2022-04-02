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
                            <h4 class="page-title"> Análise Exploratória </h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="accordion" id="accordion">
                    <div class="card mb-0 border border-primary">
                        <div class="card-header" id="headingOne">
                            <h5 class="m-0">
                                <a class="custom-accordion-title d-block pt-2 pb-2 mr-2" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Resumo Geral
                                    <i class="uil uil-arrow-down"></i>
                                </a>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordion">
                            <div class="card-body">
                                <?php $this->insert("metaData") ?>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($riders as $rider) : ?>
                        <div class="card mb-0 border border-primary">
                            <div class="card-header" id='<?= 'heading' . $this->e($rider->name) ?>'>
                                <h5 class="m-0">

                                    <div class="mb-3 d-inline">

                                        <button type="button" class="btn btn-primary" id='<?= 'button_carregar_' . $this->e($rider->name) ?>' onclick="getDataTable('<?= $this->e($rider->name) ?>', '<?= $this->e($rider->atividade) ?>','<?= $this->e($url) ?>')">Carregar Dados</button>

                                        <button class="btn btn-primary" type="button" id='<?= 'button_loading_' . $this->e($rider->name) ?>' style="display: none;">
                                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                            Loading...
                                        </button>

                                        <button type="button" id='<?= 'button_success_' . $this->e($rider->name) ?>' class="btn btn-success" style="display: none;">Sucesso</button>

                                        <button type="button" id='<?= 'button_danger_' . $this->e($rider->name) ?>' class="btn btn-danger" style="display: none;">Erro</button>

                                    </div> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="d-inline progress">
                                        <span class="d-inline progress-bar" id='<?= 'progress_bar_' . $this->e($rider->name) ?>' role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</span>
                                    </span>
                                    <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse" href='<?= '#collapse' . $this->e($rider->name) ?>' aria-expanded="true" aria-controls='<?= 'collapse' . $this->e($rider->name) ?>'>
                                        <?= 'Ciclista ' . $this->e($rider->name) . ' => ' . 'Total de Atividades: ' . $this->e($rider->atividade)  ?> <i id='<?= 'arrow' . $this->e($rider->name) ?>' class="uil uil-arrow-down" style="display: none;"></i>
                                    </a>
                                </h5>
                            </div>
                            <div id='<?= 'collapse' . $this->e($rider->name) ?>' class="collapse" aria-labelledby='<?= 'heading' . $this->e($rider->name) ?>' data-bs-parent="#accordion">
                                <div class="card-body">
                                    ...
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

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