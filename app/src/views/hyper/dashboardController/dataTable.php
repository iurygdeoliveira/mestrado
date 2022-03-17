<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="tab-content">
                    <div class="tab-pane show active" id="buttons-table-preview">
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Whatsapp</th>
                                    <th>Sexo</th>
                                    <th>Horário da Inscrição</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>

                            <?php
                            $pages = [
                                'Candidatos', 'Autorizados', 'Pagantes', 'Negados'
                            ];

                            $url = match ($pageTitle) {
                                "Candidatos" => url('/candidato'),
                                "Autorizados" => url('/autorizado'),
                                "Pagantes" => url('/pagante'),
                                "Negados" => url('/negado')
                            };
                            ?>

                            <tbody>
                                <?php foreach ($candidatos as $candidato) : ?>
                                    <tr>
                                        <td><?= $this->e($candidato->name) ?></td>
                                        <td><?= $this->e($candidato->cpf) ?></td>
                                        <td><?= $this->e($candidato->fone) ?></td>
                                        <td><?= $this->e($candidato->sexo) ?></td>
                                        <td><?= $this->e($candidato->inscricao) ?></td>
                                        <td>
                                            <span data-bs-toggle="modal" data-bs-target="#modal-processando">
                                                <a class="action-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar Dados" onclick="getCandidato('<?= $this->e($candidato->cpf) ?>','Visualizar', '<?= $url ?>')">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                            </span>
                                            <?php if (isset($pageTitle) && $pageTitle === 'Candidatos') : ?>
                                                <span data-bs-toggle="modal" data-bs-target="#modal-validar-candidato">
                                                    <a href="javascript: void(0);" class="action-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Autorizar Inscrição" onclick="getName('<?= $this->e($candidato->cpf) ?>','<?= $this->e($candidato->name) ?>','Autorizar')">
                                                        <i class="uil-user-check"></i>
                                                    </a>
                                                </span>
                                            <?php endif; ?>
                                            <?php if (isset($pageTitle) && (($pageTitle === 'Candidatos') || ($pageTitle === 'Autorizados'))) : ?>
                                                <span data-bs-toggle="modal" data-bs-target="#modal-negar-candidato">
                                                    <a href="javascript: void(0);" class="action-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Negar Inscrição" onclick="getName('<?= $this->e($candidato->cpf) ?>','<?= $this->e($candidato->name) ?>','Negar')">
                                                        <i class=" uil-user-times"></i>
                                                    </a>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div> <!-- end preview-->
                </div> <!-- end tab-content-->

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<?php $this->insert("modal-processando") ?>
<?php $this->insert("modal-success") ?>
<?php $this->insert("modal-danger") ?>
<?php $this->insert("modal-visualizar-candidato") ?>
<?php if (isset($pageTitle) && $pageTitle === 'Candidatos') : ?>
    <?php $this->insert("modal-validar-candidato") ?>
<?php endif; ?>
<?php $this->insert("modal-negar-candidato", [
    "url" => $url
]) ?>