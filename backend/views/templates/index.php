<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \backend\components\ModifiedDataColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\components\BackendModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $searchModel->getTitle();
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title"><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="panel-body">
        <?php echo $searchModel->hasSearch() ? $this->render('//templates/_search', ['model' => $searchModel]) : null; ?>

        <p>
            <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $searchModel->getColumns('index'),
            'dataColumnClass' => ModifiedDataColumn::className()
        ]); ?>

    </div>

</div>
