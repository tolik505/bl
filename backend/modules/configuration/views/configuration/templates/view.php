<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\modules\configuration\components\ConfigurationModel */

$this->title = $model->getTitle();
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title"><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="panel-body">
        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update'], ['class' => 'btn btn-primary']) ?>
        </p>

        <?php foreach ($model->getModels() as $item) : ?>
            <br>
            <?= \backend\modules\configuration\components\ConfigurationDetailView::widget([
                'model' => $item,
                'attributes' => $item->getColumns('model'),
            ]); ?>

            <p>
                <?= Html::a(
                    Yii::t('app', 'Update this item'), $item->getUpdateUrl(),
                    ['class' => 'btn btn-xs btn-default', 'target' => '_blank'])
                ?>
            </p>

        <?php endforeach ?>
    </div>

</div>
