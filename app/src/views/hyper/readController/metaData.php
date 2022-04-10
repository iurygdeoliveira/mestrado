<table class="table table-hover table-centered mb-0">
    <thead>
        <tr>
            <th class="text-center">Total de Ciclistas</th>
            <th class="text-center">Total de Atividades</th>
            <th class="text-center">Total de Datasets</th>
            <th class="text-center">Data e Hora</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center"><?= $this->e($totalCiclistas) ?></td>
            <td class="text-center"><?= $this->e($totalAtividades) ?></td>
            <td class="text-center"><?= $this->e($totalDatasets) ?></td>
            <td class="text-center" id="datetime_extract"> <?= (new DateTime())->format(CONF_DATE_APP) ?></td>
        </tr>
    </tbody>
</table>