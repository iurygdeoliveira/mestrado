<?php $this->layout("../theme/theme"); ?>

<?php $this->insert("read_begin") ?>

<div class="rightbar-overlay"></div>
<!-- /End-bar -->

<?php $this->insert("../scripts/scripts") ?>
<?php $this->insert("readData") ?>
<?php $this->insert("exportCSV") ?>