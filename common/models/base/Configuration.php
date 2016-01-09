<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%configuration}}".
 *
 * @property string $id
 * @property string $value
 * @property integer $type
 * @property string $description
 * @property integer $preload
 * @property integer $published
 * @property integer $created_at
 * @property integer $updated_at
 */
abstract class Configuration extends \common\components\model\ActiveRecord
{
    const TYPE_STRING = 0;
    const TYPE_INTEGER = 1;
    const TYPE_TEXT = 2;
    const TYPE_HTML = 3;
    const TYPE_BOOLEAN = 4;
    const TYPE_DOUBLE = 5;
    const TYPE_FILE = 6;

    protected static $type = [
        self::TYPE_STRING => 'String',
        self::TYPE_INTEGER => 'Integer',
        self::TYPE_TEXT => 'Text',
        self::TYPE_HTML => 'Html text',
        self::TYPE_BOOLEAN => 'Boolean',
        self::TYPE_DOUBLE => 'Double',
        self::TYPE_FILE => 'File',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%configuration}}';
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
            [['id', 'type'], 'required'],
            [['value'], 'string'],
            [['type', 'preload', 'published'], 'integer'],
            [['id'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['preload'], 'default', 'value' => 1],
            [['published'], 'default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Key'),
            'value' => Yii::t('app', 'Value'),
            'type' => Yii::t('app', 'Field type'),
            'description' => Yii::t('app', 'Description'),
            'preload' => Yii::t('app', 'Preload'),
            'published' => Yii::t('app', 'Published'),
        ];
    }
}
