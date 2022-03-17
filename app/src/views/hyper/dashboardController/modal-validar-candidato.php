<!-- First Info Alert Modal -->
<div id="modal-validar-candidato" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center">
                    <i class="dripicons-information h1 text-info"></i>
                    <h4 class="mt-2">Lembre-se!</h4>
                    <p class="mt-3">Antes de autorizar tenha a certeza que as informações do candidato <b><span id='inputAutorizarNome'></span></b> com CPF <b><span id='inputAutorizarCPF'></span></b> foram avaliadas e atendem aos requisitos exigidos para a participação na escola impulse</p>
                    <button type="button" class="btn btn-info my-2" data-bs-target="#modal-processando" data-bs-toggle="modal" data-bs-dismiss="modal" onclick="autorizarInscricao()">Autorizar Inscrição do candidato</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Success Alert Modal -->
<div id="modal-success-validar" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content modal-filled bg-success">
            <div class="modal-body p-4">
                <div class="text-center">
                    <i class="dripicons-checkmark h1"></i>
                    <h4 class="mt-2">Sucesso !</h4>
                    <p id="messageServerSuccessValidar" class="mt-3"></p>
                    <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal" onclick="redirect('<?= url('/candidatos') ?>')">Fechar</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->