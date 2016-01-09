<?php

namespace common\models;

use Yii;

/**
 * @inheritdoc
 *
 * @property ArticleCategory $model
 */
class ArticleCategoryTranslation extends \common\models\base\ArticleCategoryTranslation
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'model_id']);
    }

}
