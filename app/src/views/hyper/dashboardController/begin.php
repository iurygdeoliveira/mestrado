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
                    <div class="col-5 p-0" id="streamGraph">
                        <div class="container-fluid pe-0 ps-0">
                            <div class="row p-0 mb-1 ms-2 mt-1 me-2 bg-white" id="streamMetrics" style="display:none">
                                <p class="m-0 font-weight-bold text-center text-dark">
                                    Stream Metrics
                                </p>
                            </div>
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
                    <div class="col-4 p-0">
                        <div class="container-fluid pe-0 ps-0">
                            <div class="row p-0 mb-1 ms-0 mt-1 me-2 bg-white float-left" id="globalIntensity" style="display:none">
                                <p class="m-0 font-weight-bold text-center text-dark">
                                    Global Intensity
                                </p>
                            </div>
                            <div class="row p-0 m-0" id="heatmapChart">
                                <div id="pedaladas_heatmapChart"></div>
                            </div>
                            <div class="row p-0 mb-1 ms-0 mt-0 me-2 bg-white" id="trackerMap" style="display:none">
                                <p class="m-0 font-weight-bold text-center text-dark">
                                    Tracker Map
                                </p>
                            </div>
                            <div class="row p-0 m-0" id="mapChart">
                                <div id="pedaladas_mapChart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 p-0">
                        <div class="container-fluid pe-0 ps-0">
                            <div class="row p-0 mb-1 ms-2 mt-1 me-2 bg-white" id="statsChart" style="display:none">
                                <p class="m-0 font-weight-bold text-center text-dark">
                                    StatsChart
                                </p>
                            </div>
                            <div class="row p-0 m-0" id="radarChartAVG">
                                <div id="pedaladas_radarChartAVG"></div>
                            </div>
                            <div class="row p-0 m-0" id="radarChartSingle">
                                <div id="pedaladas_radarChartSingle"></div>
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