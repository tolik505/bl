<?php
/**
 * @var $model MailRequest
 * @var $success boolean
 */
use yii\widgets\ActiveForm;
use common\models\MailRequest;
use common\helpers\LanguageHelper;
?>
<div class="footer-widget mail-subscribe-widget">
    <h4><?= Yii::t('app', 'Get in touch') ?><span class="head-line"></span></h4>
    <p><?= Yii::t('app', 'Join our mailing list to stay up to date and get notices about our new releases!') ?></p>
    <?php $form = ActiveForm::begin([
        'id' => 'subscribe',
        'action' => MailRequest::getSubscribeUrl(),
        'options' => [
            'class' => 'subscribe ajax-form'
        ],
        'fieldConfig' => [
            'template' => '{input}',
        ]
    ]); ?>
    <?= $form->field($model, 'label')->textInput(['placeholder' => 'mail@example.com']) ?>
    <?= $form->field($model, 'language')->hiddenInput(['value' => LanguageHelper::getCurrent()->code]) ?>

    <input type="submit" class="main-button" value="<?= isset($success) ? Yii::t('app', 'Done') : Yii::t('app', 'Send') ?>">
    <?= $form->errorSummary($model); ?>

    <?php ActiveForm::end() ?>
</div>
