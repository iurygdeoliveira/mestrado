<div class="d-flex justify-content-center">
    <button type="button" class="btn btn-light btn-sm col-12" id="search_rides" onclick="searchRiders()" data-bs-toggle="modal" data-bs-target="#modalTableLens" disabled>
        Buscar Pedaladas &nbsp;<i id="icon_search_rides" class="uil uil-arrow-circle-down m-0"></i>
    </button>
</div>
<div class="d-flex justify-content-center">
    <button type="button" class="btn btn-light btn-sm col-12" id="search_rides_update" onclick="searchRiders()" data-bs-toggle="modal" data-bs-target="#modalTableLens" style="display: none;">
        Atualizar Pedaladas &nbsp;<i id="icon_search_rides" class="uil uil-arrow-circle-down m-0"></i>
    </button>
</div>
<div class="d-flex justify-content-center">
    <button type="button" class="btn btn-light btn-sm col-12" id="search_rides_loading" disabled style="display: none;">
        Buscando ... &nbsp;<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
    </button>
</div>
<div class="d-flex justify-content-center">
    <button type="button" class="btn btn-success btn-sm col-12" id="search_rides_success" style="display: none;">
        Sucesso &nbsp;<i id="icon_search_rides" class="uil uil-check-circle"></i>
    </button>
</div>
<div class="d-flex justify-content-center">
    <button type="button" class="btn btn-danger btn-sm col-12" id="search_rides_danger" style="display: none;">
        Erro &nbsp;<i id="icon_search_rides" class="uil uil-times-circle"></i>
    </button>
</div>