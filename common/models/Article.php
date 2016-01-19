<?php

namespace common\models;

use himiklab\sitemap\behaviors\SitemapBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * @inheritdoc
 *
 * @property ArticleCategory $category
 * @property EntityToFile $titleImage
 * @property ArticleTranslation[] $translations
 */
class Article extends \common\models\base\Article implements \common\components\model\Translateable
{
    use \backend\components\TranslateableTrait;

    /**
     * @return array
     */
    public static function getTranslationAttributes()
    {
        return [
            'label',
            'announce',
            'content',
            'tags',
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
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
            ],
            'sitemap' => [
                'class' => SitemapBehavior::className(),
                'scope' => function ($model) {
                    /** @var \yii\db\ActiveQuery $model */
                    $model->andWhere(['published' => 1]);
                },
                'dataClosure' => function ($model) {
                    /** @var self $model */
                    return [
                        'loc' => Url::to($model->getViewUrl(), true),
                        'lastmod' => $model->updated_at,
                        'changefreq' => SitemapBehavior::CHANGEFREQ_WEEKLY,
                        'priority' => 0.8
                    ];
                }
            ],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(ArticleTranslation::className(), ['model_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTitleImage()
    {
        return $this->hasOne(EntityToFile::className(), ['entity_model_id' => 'id'])
            ->andOnCondition(['t2.entity_model_name' => static::formName(), 't2.attribute' => EntityToFile::TYPE_ARTICLE_TITLE_IMAGE])
            ->from(['t2' => EntityToFile::tableName()])
            ->orderBy('t2.position DESC');
    }

    /** @return string */
    public function getCategoryLabel()
    {
        if (isset($this->category->label)) {
            return $this->category->label;
        }

        return '';
    }

    /** @return string */
    public function getCategoryUrl()
    {
        if (isset($this->category->label)) {
            return $this->category->getIndexUrl();
        }

        return '#';
    }

    /** @return string */
    public function getAnnounce()
    {
        if ($this->announce) {
            return $this->announce;
        }

        return $this->getCutText(null, 520);
    }

    /**
     * @param $params array
     * @return string
     */
    public function getViewUrl($params = [])
    {
        $params = ArrayHelper::merge(['alias' => $this->alias], $params);
        return $this->createUrl('/article/default/view', $params);
    }

    /** @return string */
    public static function getSearchRoute()
    {
        return '/article/search/index';
    }

    /**
     * @param $params array
     * @return string
     */
    public static function getSearchUrl($params = [])
    {
        return static::createUrl(static::getSearchRoute(), $params);
    }
}
