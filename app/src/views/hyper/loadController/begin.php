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
                            <h4 class="page-title"> Carregar Dados </h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->


                <div class="card">
                    <div class="card-header">
                        Clique no botão abaixo para carregar os dados no sistema
                    </div>
                    <div class="card-body">
                        <a href="javascript: void(0);" class="btn btn-primary">Carregar </a>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                        </div>
                    </div>
                </div>

            </div> <!-- end container -->

        </div> <!-- end content -->


        <?php $this->insert("footer") ?>

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->