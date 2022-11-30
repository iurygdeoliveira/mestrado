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
                            <div class="row p-0 m-0" id="streamHeartrate">
                                <div id="pedaladas_heartrate"></div>
                            </div>
                            <div class="row p-0 m-0" id="streamSpeed">
                                <div id="pedaladas_speed"></div>
                            </div>
                            <div class="row p-0 m-0" id="streamElevation">
                                <div id="pedaladas_elevation"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5 p-0">
                        <div class="container-fluid pe-0 ps-0">
                            <div class="row p-0 m-0" id="radarChart">
                                <div id="pedaladas_radarChart"></div>
                            </div>
                            <div class="row p-0 m-0" id="mapChart">
                                <div id="pedaladas_mapChart"></div>
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