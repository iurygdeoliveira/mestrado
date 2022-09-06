<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu p-0">

    <!-- <a href="#" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="<?= img('logo.png') ?>" alt="" height="70">
        </span>
    </a> -->

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">
            <li class="side-nav-item">
                <div class="side-nav-link pb-0">
                    <div class="row">
                        <span class="text-center mb-1">
                            1º Selecionar Ciclistas:
                        </span>
                    </div>
                    <div class="row">
                        <span class="form-check col-2 me-1" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider1" name="rider1">
                            <label class="form-check-label">1</label>
                        </span>
                        <span class="form-check col-2 me-1" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider2" name="rider2">
                            <label class="form-check-label">2</label>
                        </span>
                        <span class="form-check col-2 me-1" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider3" name="rider3">
                            <label class="form-check-label">3</label>
                        </span>
                        <span class="form-check col-2 me-1" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider4" name="rider4">
                            <label class="form-check-label">4</label>
                        </span>
                        <span class="form-check col-2 me-1" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider5" name="rider5">
                            <label class="form-check-label">5</label>
                        </span>
                    </div>
                    <div class="row">
                        <span class="form-check col-2 me-1" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider6" name="rider1">
                            <label class="form-check-label">6</label>
                        </span>
                        <span class="form-check col-2 me-1" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider7" name="rider7">
                            <label class="form-check-label">7</label>
                        </span>
                        <span class="form-check col-2 me-1" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider8" name="rider8">
                            <label class="form-check-label">8</label>
                        </span>
                        <span class="form-check col-2 me-1" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider9" name="rider9">
                            <label class="form-check-label">9</label>
                        </span>
                        <span class="form-check col-2 me-1" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider10" name="rider10">
                            <label class="form-check-label">10</label>
                        </span>
                    </div>
                    <div class="row">
                        <span class="form-check col-3" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider11" name="rider11">
                            <label class="form-check-label">11</label>
                        </span>
                        <span class="form-check col-3" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider12" name="rider12">
                            <label class="form-check-label">12</label>
                        </span>
                        <span class="form-check col-3" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider13" name="rider13">
                            <label class="form-check-label">13</label>
                        </span>
                        <span class="form-check col-3" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider14" name="rider14">
                            <label class="form-check-label">14</label>
                        </span>
                    </div>
                    <div class="row">
                        <span class="form-check col-3" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider15" name="rider15">
                            <label class="form-check-label">15</label>
                        </span>
                        <span class="form-check col-3" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider16" name="rider16">
                            <label class="form-check-label">16</label>
                        </span>
                        <span class="form-check col-3" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider17" name="rider17">
                            <label class="form-check-label">17</label>
                        </span>
                        <span class="form-check col-3" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider18" name="rider18">
                            <label class="form-check-label">18</label>
                        </span>
                    </div>
                    <div class="row">
                        <span class="form-check col-3" style="display:inline-block">
                            <input type='checkbox' class="form-check-input" id="rider19" name=" rider19">
                            <label class="form-check-label">19</label>
                        </span>
                    </div>
                </div>
            </li>


            <li class="side-nav-item">
                <div class="side-nav-link pb-0">
                    <div class="row">
                        <span class="text-center">
                            <label for="distance">2º Selecionar Distância:</label>
                        </span>
                    </div>
                    <div class="row">
                        <span class="text-center mb-1">
                            <div id="distance" style="border:0; color:#FFF; font-weight:bold;">
                                <span id="range-min">0</span> KM - <span id="range-max">?</span> KM
                            </div>
                    </div>
                    <div class="mb-2" id="slider-range" style="display: none;"></div>

                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-light btn-sm col-12" id="search_rides" onclick="searchRiders()" disabled>
                            Buscar Pedaladas &nbsp;<i id="icon_search_rides" class="uil uil-arrow-circle-down m-0"></i>
                        </button>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-light btn-sm col-12" id="search_rides_update" onclick="searchRiders()" style="display: none;">
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
                </div>
            </li>

            <li class="side-nav-item">
                <div class="side-nav-link">
                    <script>
                        document.write('2021 - ' + (new Date().getFullYear()))
                    </script> © CycleVis
                </div>
            </li>
        </ul>


        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->