<?php

namespace common\models\base;

use Yii;
use notgosu\yii2\modules\metaTag\components\MetaTagBehavior;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $label
 * @property string $alias
 * @property integer $category_id
 * @property string $announce
 * @property string $content
 * @property string $date
 * @property string $tags
 * @property integer $views
 * @property integer $published
 * @property integer $position
 * @property integer $created_at
 * @property integer $updated_at
 */
abstract class Article extends \common\components\model\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'seo' => [
                'class' => MetaTagBehavior::className(),
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label', 'alias', 'content', 'date'], 'required'],
            [['category_id', 'views', 'published', 'position'], 'integer'],
            [['announce', 'content'], 'string'],
            [['date'], 'date', 'format' => 'yyyy-MM-dd'],
            [['label', 'alias', 'tags'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'targetClass' => \common\models\ArticleCategory::className(), 'targetAttribute' => 'id'],
            [['views'], 'default', 'value' => 0],
            [['published'], 'default', 'value' => 1],
            [['position'], 'default', 'value' => 0],
            [['alias'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'label' => Yii::t('app', 'Label'),
            'alias' => Yii::t('app', 'Alias'),
            'category_id' => Yii::t('app', 'Article category'),
            'announce' => Yii::t('app', 'Announce'),
            'content' => Yii::t('app', 'Content'),
            'date' => Yii::t('app', 'Date'),
            'tags' => Yii::t('app', 'Tags'),
            'views' => Yii::t('app', 'Views'),
            'published' => Yii::t('app', 'Published'),
            'position' => Yii::t('app', 'Position'),
        ];
    }
}
