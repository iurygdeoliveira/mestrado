<!-- Begin page -->
<table class="table table-hover table-centered mb-0 border-primary border">
    <thead>
        <tr>
            <th class='col-1 text-center'>Ciclista</th>
            <th class='col-2 text-center'>Total de Atividades</th>
            <th class='col-7 text-center'>Status</th>
            <th class='col-2 text-center'>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($riders as $rider) : ?>
            <tr>
                <td class='col-1 text-center'>
                    <a href="#" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" title='<?= $this->e($rider->table) ?>'>
                        <?= $this->e($rider->name) ?>
                    </a>
                </td>
                <td class='col-2 text-center' id='<?= 'rider_' . $this->e($rider->name) . '_activity' ?>'>
                    <?= $this->e($rider->atividade) ?>
                </td>
                <td class="col-7">
                    <span class="progress">
                        <div class="progress-bar" id='<?= 'progress_bar_' . $this->e($rider->name) ?>' role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </span>
                    <p class="card-text text-danger" style="display:none" id='<?= 'rider_' . $this->e($rider->name) . '_error' ?>'>
                    </p>
                </td>
                </td>
                <td class='col-2'>
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary" id='<?= 'button_carregar_' . $this->e($rider->name) ?>' onclick="extractActivities('<?= $this->e($rider->name) ?>', '<?= $this->e($rider->table) ?>', '<?= $this->e($rider->atividade) ?>','<?= $this->e($url_readData) ?>')">Extrair</button>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary" type="button" id='<?= 'button_loading_' . $this->e($rider->name) ?>' style="display: none;">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            Gerando...
                        </button disabled>
                    </div>
                    <div class="d-grid">
                        <button type="button" id='<?= 'button_success_' . $this->e($rider->name) ?>' class="btn btn-success" style="display: none;">Sucesso</button disabled>
                    </div>
                    <div class="d-grid">
                        <button type="button" id='<?= 'button_danger_' . $this->e($rider->name) ?>' class="btn btn-danger" style="display: none;" onclick="extractActivities('<?= $this->e($rider->name) ?>', '<?= $this->e($rider->table) ?>', '<?= $this->e($rider->atividade) ?>','<?= $this->e($url_readData) ?>','<?= $this->e($url_sendBbox) ?>')">Erro (Tentar novamente) </button>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>