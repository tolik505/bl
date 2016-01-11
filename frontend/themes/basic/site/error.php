<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $code string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<?= $this->render('@app/themes/basic/layouts/_header', ['breadcrumbsLinks' => null]) ?>

<div class="page-content">


    <div class="error-page">
        <h1><?= Html::encode($code) ?></h1>
        <h3><?= Html::encode($this->title) ?></h3>
        <p><?= nl2br(Html::encode($message)) ?></p>
        <div class="text-center"><a href="<?= Yii::$app->homeUrl ?>" class="btn-system btn-small"><?= Yii::t('app', 'Back To Home') ?></a></div>
    </div>


</div>
<?= $this->render('@app/themes/basic/layouts/_footer') ?>
