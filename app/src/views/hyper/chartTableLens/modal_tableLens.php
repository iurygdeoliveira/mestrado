<div id="modalTableLens" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-full-width">
        <div class="modal-content h-100">
            <div class="modal-header">
                <div class="container-fluid">
                    <div class="row">
                        <h4 class="modal-title text-dark text-center col-11">Escolher Ciclista</h4>
                        <button type="button" class="btn-close col-1" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>
                    <div class="row">
                        <div class="col-1 d-flex">
                            <h5 class="modal-title text-dark pe-0" id="fullWidthModalLabel">Filtros:</h5>
                            <div class="ms-2 me-2 text-dark">Visão Geral:</div>
                            <div class="d-inline form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                    style="background-color: rgb(90,90,90); background-image: url(<?= img('switch_toogle.svg') ?>);"
                                    role="switch" id="switchToggle">
                            </div>
                            <div class="ms-1 me-2 text-dark">Item</div>
                            <div class="ms-2 me-2 text-dark">Decrescente</div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                    style="background-color: rgb(90,90,90); background-image: url(<?= img('switch_toogle.svg') ?>);"
                                    role="switch" id="switchOrder">
                            </div>
                            <div class="ms-1 me-2 text-dark">Crescente</div>
                        </div>
                    </div>
                </div>
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