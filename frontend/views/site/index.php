<?php
use yii\bootstrap\Html;

?>
<?php foreach ($modelList as $i => $model): ?>
    <div class="panel panel-<?= ($model->apiStatus->getStatus() == 'ok') ? 'success' : 'danger'; ?>">
        <div class="panel-heading" role="tab" id="headingThree">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>" aria-expanded="false" aria-controls="collapse<?= $i ?>">
                    <?= Html::encode($model->name) ?>
                </a>
            </h4>
        </div>
        <div id="collapse<?= $i ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>Status</td>
                                <td><?= Html::encode($model->apiStatus->getStatus()) ?></td>
                            </tr>
                            <tr>
                                <td>Last time checked</td>
                                <td><?= Html::encode($model->last_time_checked) ?></td>
                            </tr>
                            <tr>
                                <td>Last time working</td>
                                <td><?= Html::encode($model->last_time_working) ?></td>
                            </tr>
                            <tr>
                                <td>Latency</td>
                                <td><?= Html::encode($model->apiStatus->latency) ?> ms</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
