<?php

use yii\helpers\Html;
use \backend\modules\about\models\AboutIsfed;
use \backend\modules\about\models\AboutGames;

/* @var $this yii\web\View */
/* @var $model \backend\components\BackendModel */

$this->title = $model->hasAttribute('label') && $model->label ? $model->label : $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->getTitle()), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title"><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="panel-body">
        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php //if (!in_array($model->className(), [])) { ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
            <?php //} ?>
        </p>

        <?= \backend\components\LanguageDetailView::widget([
            'model' => $model,
            'attributes' => $model->getColumns('view'),
        ]) ?>
    </div>

</div>
