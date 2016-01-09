<?php

namespace common\models;

use Yii;

/**
 * @inheritdoc
 *
 * @property Article $model
 */
class ArticleTranslation extends \common\models\base\ArticleTranslation
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(Article::className(), ['id' => 'model_id']);
    }

}
