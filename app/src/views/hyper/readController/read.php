<?php $this->layout("../theme/theme"); ?>

<?php $this->insert("read_begin") ?>

<div class="rightbar-overlay"></div>
<!-- /End-bar -->

<?php $this->insert("../scripts/scripts") ?>
<?php $this->insert("../scripts/github") ?>
<?php $this->insert("../scripts/getPedaladas") ?>
<?php $this->insert("../scripts/getDistances") ?>
<?php $this->insert("../scripts/globalVariables") ?>
<?php $this->insert("../scripts/updateSlider") ?>
<?php $this->insert("../scripts/updateButtons") ?>
<?php $this->insert("../scripts/checkboxRiders") ?>
<?php $this->insert("../chartTableLens/js_createTableLens") ?>
<?php $this->insert("../chartTableLens/js_animationTableLens") ?>
<?php $this->insert("../chartTableLens/js_skeletonTableLens") ?>
<?php $this->insert("../chartMap/layer_hotline") ?>
<?php $this->insert("../chartMap/layer_route") ?>
<?php $this->insert("../chartMap/layer_distance") ?>
<?php $this->insert("../chartMap/js_mapChart") ?>
<?php $this->insert("../chartRadar/js_radarChartAVG") ?>
<?php $this->insert("../chartRadar/js_radarChartSingle") ?>
<?php $this->insert("../chartHeatmap/js_heatmapChart") ?>
<?php $this->insert("../chartStream/js_streamChart") ?>
<?php $this->insert("../chartStream/js_elevationStream") ?>
<?php $this->insert("../chartBar/js_barChart") ?>
<?php $this->insert("../scripts/enableTooltips") ?>
<?php $this->insert("../scripts/generateMultiVis") ?>
<?php $this->insert("readData") ?>
<?php $this->insert("exportData") ?>