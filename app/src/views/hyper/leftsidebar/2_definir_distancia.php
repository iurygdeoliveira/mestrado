<div class="row">
    <div class="col-8">
        <span class="text-center mb-1">
            <div id="distance" style="border:0; color:#FFF; font-weight:bold; font-size: .80rem">
                <span id="range-min">5</span> to <span id="range-max">?</span> KM
            </div>
        </span>
        <div class="mb-0 mt-1" id="slider-range" style="display: none;"></div>
    </div>
    <div class="col-4">
        <div class="d-flex justify-content-center mt-2">
            <button type="button" class="btn btn-light btn-sm col-12" id="search_rides" onclick="verPedaladas()" data-bs-toggle="modal" data-bs-target="#modalTableLens" disabled title="Generate Table Lens">
                <i class="uil uil-align-left"></i>
            </button>
        </div>
        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-light btn-sm col-12" id="search_rides_loading" disabled style="display: none;">
                Buscando ... &nbsp;<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
            </button>
        </div>
        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-danger btn-sm col-12" id="search_rides_danger" style="display: none;">
                Erro &nbsp;<i id="icon_search_rides" class="uil uil-times-circle"></i>
            </button>
        </div>
    </div>
</div>
<?php $this->insert("../leftsidebar/modalTableLens") ?>