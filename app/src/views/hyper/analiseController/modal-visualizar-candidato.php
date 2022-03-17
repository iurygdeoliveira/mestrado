<!-- Primary Header Modal -->

<div id="modal-visualizar-candidato" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-visualizar-candidato-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary">
                <h4 class="modal-title" id="modal-visualizar-candidato-label">Dados do Candidato</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Nome: <span id='inputTituloNome'></span></h4>
                                <ul class="nav nav-tabs nav-bordered mb-3">
                                    <li class="nav-item">
                                        <a href="#input-dados-pessoais" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                            Dados Pessoais
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#input-vida-familiar" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                            Vida Familiar
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#input-vida-cristã" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                            Vida Cristã
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane" id="input-dados-pessoais">
                                        <?php $this->insert("formDadosPessoais") ?>
                                    </div> <!-- end dados pessoais -->

                                    <div class="tab-pane" id="input-vida-familiar">
                                        <?php $this->insert("formVidaFamiliar") ?>
                                    </div> <!-- end vida cristã -->

                                    <div class="tab-pane" id="input-vida-cristã">
                                        <?php $this->insert("formVidaCrista") ?>
                                    </div> <!-- end vida familiar -->
                                </div>



                            </div> <!-- end card-body -->
                        </div> <!-- end card -->
                    </div><!-- end col -->
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->