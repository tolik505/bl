<?php

namespace common\models;

use Yii;

/**
 * @inheritdoc
 *
 * @property Article[] $articles
 * @property ArticleCategoryTranslation[] $translations
 */
class ArticleCategory extends \common\models\base\ArticleCategory implements \common\components\model\Translateable
{
    use \backend\components\TranslateableTrait;

    /**
     * @return array
     */
    public static function getTranslationAttributes()
    {
        return [
            'label',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'translateable' => [
                'class' => \creocoder\translateable\TranslateableBehavior::className(),
                'translationAttributes' => static::getTranslationAttributes(),
            ],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(ArticleCategoryTranslation::className(), ['model_id' => 'id']);
    }

    /** @return string */
    public static function getIndexRoute()
    {
        return '/article/default/category';
    }

    /** @return string */
    public function getIndexUrl()
    {
        return $this->createUrl(static::getIndexRoute(), ['alias' => $this->alias]);
    }
}
