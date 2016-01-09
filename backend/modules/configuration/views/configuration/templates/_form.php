<?php

use common\helpers\LanguageHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\modules\configuration\components\ConfigurationModel */

$values = $model->getModels();
?>

<div class="menu-form">
    <?= Html::errorSummary(
        $values,
        [
            'class' => 'alert alert-danger'
        ]
    );
    ?>
    <?php /** @var \metalguardian\formBuilder\ActiveFormBuilder $form */ $form = \metalguardian\formBuilder\ActiveFormBuilder::begin(); ?>

    <?php
    $items = [];

    $content = null;
    foreach ($values as $value) {
        $attribute = '[' . $value->id . ']value';
        $configuration = $value->getValueFieldConfig();
        $configuration['label'] = $value->description . ' [key: ' . $value->id . '] [language: ' . LanguageHelper::getCurrent()->code . ']';
        $content .= $form->renderField($value, $attribute, $configuration);
        if ($value instanceof \common\components\model\Translateable && $value->isTranslateAttribute($attribute)) {
            foreach ($value->getTranslationModels() as $languageModel) {
                $configuration['label'] = $value->description . ' [key: ' . $value->id . '] [language: ' . $languageModel->language . ']';
                $content .= $form->renderField($languageModel, '[' . $languageModel->language . ']' . $attribute, $configuration);
            }
        }
    }

    echo $content;
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php \metalguardian\formBuilder\ActiveFormBuilder::end(); ?>

</div>
