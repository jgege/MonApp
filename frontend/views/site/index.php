<?php foreach ($modelList as $model): ?>
    <div>
        <?= $model->name ?> - <?= $model->apiStatus->getStatus() ?>
    </div>
<?php endforeach; ?>