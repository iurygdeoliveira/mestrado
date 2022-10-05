<div id="modalTableLens" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-full-width">
        <div class="modal-content h-100">
            <div class="modal-header">
                <h4 class="modal-title text-dark" id="fullWidthModalLabel">Filters:</h4>
                <div class="ms-2 me-2 text-dark">Overview</div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" style="background-color: rgb(90,90,90); background-image: url(<?= img('switch_toogle.svg') ?>);" role="switch" id="switchToggle">
                </div>
                <div class="ms-1 me-2 text-dark">Item</div>
                <div class="ms-2 me-2 text-dark">Descending</div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" style="background-color: rgb(90,90,90); background-image: url(<?= img('switch_toogle.svg') ?>);" role="switch" id="switchOrder">
                </div>
                <div class="ms-1 me-2 text-dark">Ascending</div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body p-1">
                <div class="container-fluid px-1 py-1">
                    <div class="row" id="table_lens_label">
                    </div>
                    <div class="row" id="table_lens_box">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->