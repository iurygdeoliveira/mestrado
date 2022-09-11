<div class="d-flex justify-content-center">
    <button type="button" class="btn btn-light btn-sm col-12" id="search_rides" onclick="verPedaladas()" data-bs-toggle="modal" data-bs-target="#modalTableLens" disabled>
        Ver Pedaladas &nbsp;<i id="icon_search_rides" class="uil uil-eye m-0"></i>
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