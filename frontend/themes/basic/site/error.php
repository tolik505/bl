<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $code string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="page-404">
    <div class="wrap">
        <span><?= Html::encode($this->title) ?></span>
        <strong><?= Html::encode($code) ?></strong>
        <p><?= nl2br(Html::encode($message)) ?></p>
        <a href="/" class="btn green"><?= Yii::t('app', 'back to main') ?></a>
    </div>
</div>
