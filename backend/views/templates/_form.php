<?php

use yii\helpers\Html;
use metalguardian\fileProcessor\helpers\FPM;
use  \backend\components\FormBuilder;

/* @var $this yii\web\View */
/* @var $model \backend\components\BackendModel */
/* @var $form yii\bootstrap\ActiveForm */
$translationModels = [];
if ($model instanceof \common\components\model\Translateable) {
    $translationModels = $model->getTranslationModels();
}
$action = isset($action) ? $action : '';
?>

<div class="menu-form">
    <?= Html::errorSummary(
        \yii\helpers\ArrayHelper::merge([$model], $translationModels),
        [
            'class' => 'alert alert-danger'
        ]
    );
    ?>
    <?php /** @var FormBuilder $form */ $form = FormBuilder::begin([
        'action' => $action,
        'enableClientValidation' => false,
        'options' => [
            'id' => 'main-form',
            'enctype' => 'multipart/form-data',
        ]
    ]); ?>

    <?php
    $items = [];


    $formConfig = $model->getFormConfig();

    $content = null;
    foreach ($formConfig as $attribute => $element) {
        $content .= $form->renderField($model, $attribute, $element);
        $content .= $form->renderUploadedFile($model, $attribute, $element);
        if ($model instanceof \common\components\model\Translateable && $model->isTranslateAttribute($attribute)) {
            foreach ($translationModels as $languageModel) {
                $content .= $form->renderField($languageModel, '[' . $languageModel->language . ']' . $attribute, $element);
                $content .= $form->renderUploadedFile($languageModel, $attribute, $element, $languageModel->language);
            }
        }
    }

    $items[] = [
        'label' => 'Content',
        'content' => $content,
        'active' => true,
        'options' => [
            'class' => 'tab_content_content',
        ],
        'linkOptions' => [
            'class' => 'tab_content',
        ],
    ];

    $seo = $model->getBehavior('seo');
    if ($seo && $seo instanceof \notgosu\yii2\modules\metaTag\components\MetaTagBehavior) {
        $seo = \notgosu\yii2\modules\metaTag\widgets\metaTagForm\Widget::widget(['model' => $model, ]);
        $items[] = [
            'label' => 'SEO',
            'content' => $seo,
            'active' => false,
            'options' => [
                'class' => 'tab_seo_content',
            ],
            'linkOptions' => [
                'class' => 'tab_seo',
            ],
        ];
    }

    ?>

    <?= \yii\bootstrap\Tabs::widget(['items' => $items]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php FormBuilder::end(); ?>

</div>
