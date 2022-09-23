<div id="modalTableLens" class="modal fade" tabindex="-1" style="z-index: 3" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-full-width position-absolute top-0" style="left: 20%!important; width:79%;">
        <div class="modal-content h-100">
            <div class="modal-header">
                <h4 class="modal-title text-dark" id="fullWidthModalLabel">Filtros:</h4>
                <div class="ms-2 me-2 text-dark">Visão Geral</div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" style="background-color: rgb(90,90,90); background-image: url(<?= img('switch_toogle.svg') ?>);" role="switch" id="switchToggle">
                </div>
                <div class="ms-1 me-2 text-dark">Selecionar Item</div>
                <div class="ms-2 me-2 text-dark">Descrescente</div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" style="background-color: rgb(90,90,90); background-image: url(<?= img('switch_toogle.svg') ?>);" role="switch" id="switchOrder">
                </div>
                <div class="ms-1 me-2 text-dark">Crescente</div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body p-1">
                <a id="svg0_tooltip" class="d-inline-block position-absolute" data-bs-html="true" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-delay='0'>
                    <svg id="svg0">
                    </svg>
                </a>
                <a id="svg1_tooltip" class="d-inline-block position-absolute" data-bs-toggle="tooltip" data-bs-delay='0'>
                    <svg id="svg1">
                    </svg>
                </a>
                <a id="svg2_tooltip" class="d-inline-block position-absolute" data-bs-toggle="tooltip" data-bs-delay='0'>
                    <svg id="svg2">
                    </svg>
                </a>
                <a id="svg3_tooltip" class="d-inline-block position-absolute" data-bs-toggle="tooltip" data-bs-delay='0'>
                    <svg id="svg3">
                    </svg>
                </a>
                <a id="svg4_tooltip" class="d-inline-block position-absolute" data-bs-toggle="tooltip" data-bs-delay='0'>
                    <svg id="svg4">
                    </svg>
                </a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->