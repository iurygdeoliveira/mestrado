<!-- Begin page -->
<div class="wrapper">

    <?php $this->insert("../leftsidebar/leftsidebar") ?>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page p-1">
        <div class="content" id="contentCharts">
            <!-- Start Content-->
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row h-100">
                    <div class="col-7 p-0" id="streamGraph">
                        <div class="container-fluid pe-0 ps-0">
                            <div class="row p-0 m-0" id="streamGraph1">
                            </div>
                            <div class="row p-0 m-0" id="streamGraph2">
                            </div>
                            <div class="row p-0 m-0" id="streamGraph3">
                            </div>
                        </div>
                    </div>
                    <div class="col-5 p-0">
                        <div class="container-fluid pe-0 ps-0">
                            <div class="row p-0 m-0" id="radarChart">
                                <div class="p-0 m-0" id="pedaladas_radarChart"></div>
                            </div>
                            <div class="row p-0 m-0" id="mapChart">
                                <div class="p-0 m-0" id="pedaladas_mapChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div> <!-- end container -->

        </div> <!-- end content -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    <?php $this->insert("../chartTableLens/modal_tableLens") ?>

</div>
<!-- END wrapper -->