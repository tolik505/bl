<?php

namespace frontend\modules\article\models;

use common\components\Translate;


/**
 * Class ArticleCategory
 * @package frontend\modules\article\models
 */
class ArticleCategory extends \common\models\ArticleCategory {
    use Translate;

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id'])
            ->from(['t1' => Article::tableName()])
            ->andOnCondition(['t1.published' => 1]);
    }
}
