<?php
/**
 * Author: metal
 * Email: metal
 */

namespace backend\components;

use yii\widgets\DetailView;

/**
 * Class LanguageDetailView
 * @package backend\components
 */
class LanguageDetailView extends DetailView
{
    public function init()
    {
        parent::init();

        if ($this->model instanceof \common\components\model\Translateable) {
            $attributes = [];
            foreach ($this->attributes as $attribute) {
                $attributes[] = $attribute;
                if ($this->model->isTranslateAttribute($attribute['attribute'])) {
                    foreach ($this->model->getTranslationModels() as $model) {
                        $attribute['label'] = $model->getAttributeLabel($attribute['attribute']);
                        $attribute['value'] = $model->{$attribute['attribute']};
                        $attributes[] = $attribute;
                    }
                }
            }
            $this->attributes = $attributes;
        }
    }
}
