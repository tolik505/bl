<?php
/**
 * Created by PhpStorm.
 * User: anatolii
 * Date: 30.12.15
 * Time: 9:40
 */

namespace backend\components;


use common\components\model\ActiveRecord;
use metalguardian\fileProcessor\helpers\FPM;
use metalguardian\formBuilder\ActiveFormBuilder;
use yii\helpers\Html;

class FormBuilder extends ActiveFormBuilder
{
    /**
     * @param $attribute
     * @param array $element
     * @param ActiveRecord $model
     * @param string|null $language
     *
     * @return string
     */
    public function renderUploadedFile($model, $attribute, $element, $language = null)
    {
        $content = '';
        if ($element['type'] == static::INPUT_FILE && isset($model->$attribute) && $model->$attribute) {
            $file = FPM::transfer()->getData($model->$attribute);
            $content .= Html::beginTag('div', ['class' => 'file-name']);
            $content .= Html::button(\Yii::t('app', 'Delete file'), [
                'class' => 'delete-file',
                'data' => [
                    'modelName' => $model->className(),
                    'modelId' => $language ? $model->model_id : $model->id,
                    'attribute' => $attribute,
                    'language' => $language
                ]
            ]);
            if (in_array($file->extension, ['jpg', 'png', 'gif', 'tif', 'bmp'])) {
                $linkLabel = FPM::image($file->id, 'admin', 'file');
            } else {
                $linkLabel = FPM::getOriginalFileName($file->id, $file->base_name, $file->extension);
            }
            $content .= Html::a(
                $linkLabel,
                FPM::originalSrc($model->$attribute),
                ['target' => '_blank']
            );
            $content .= Html::endTag('div');
        }
        return $content;
    }
}
