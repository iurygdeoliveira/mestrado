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

                <?php $this->insert("dataTable") ?>

            </div> <!-- end container -->

        </div> <!-- end content -->


        <?php $this->insert("footer") ?>

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->