<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "article_translation".
 *
 * @property integer $model_id
 * @property string $language
 * @property string $label
 * @property string $announce
 * @property string $content
 * @property string $tags
 */
abstract class ArticleTranslation extends \common\components\model\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_translation';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['announce', 'content'], 'string'],
            [['label', 'tags'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'label' => Yii::t('app', 'Label') . ' [' . $this->language . ']',
            'announce' => Yii::t('app', 'Announce') . ' [' . $this->language . ']',
            'content' => Yii::t('app', 'Content') . ' [' . $this->language . ']',
            'tags' => Yii::t('app', 'Tags') . ' [' . $this->language . ']',
        ];
    }
}
