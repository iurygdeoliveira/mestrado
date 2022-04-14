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
                            <h4 class="page-title"> Pré-Processando os arquivos GPX e TCX </h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="col-12">
                    <div class="card border-primary border">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Resumo Geral dos Dados</h5>
                            <p class="card-text"><?php $this->insert("metaData") ?></p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div>

                <?php $this->insert("preprocessar_table") ?>

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