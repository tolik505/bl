<?php

namespace common\models\base;

use Yii;
use notgosu\yii2\modules\metaTag\components\MetaTagBehavior;

/**
 * This is the model class for table "article_category".
 *
 * @property integer $id
 * @property string $label
 * @property string $alias
 * @property integer $published
 * @property integer $position
 */
abstract class ArticleCategory extends \common\components\model\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
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
            [['label', 'alias'], 'required'],
            [['published', 'position'], 'integer'],
            [['label', 'alias'], 'string', 'max' => 255],
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
            'published' => Yii::t('app', 'Published'),
            'position' => Yii::t('app', 'Position'),
        ];
    }
}
