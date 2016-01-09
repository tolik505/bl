<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property string $model_name
 * @property integer $model_id
 * @property integer $user_id
 * @property string $name
 * @property string $content
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property integer $status_id
 * @property integer $published
 * @property integer $position
 * @property integer $created_at
 * @property integer $updated_at
 */
abstract class Comment extends \common\components\model\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
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
            [['model_name', 'model_id', 'content'], 'required'],
            [['name'], 'required', 'on' => 'isGuest'],
            [['model_id', 'user_id', 'tree', 'lft', 'rgt', 'depth', 'status_id', 'published', 'position'], 'integer'],
            [['content'], 'string'],
            [['model_name', 'name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'targetClass' => \common\models\User::className(), 'targetAttribute' => 'id'],
            [['status_id'], 'default', 'value' => 0],
            [['published'], 'default', 'value' => 1],
            [['position'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model_name' => Yii::t('app', 'Model Name'),
            'model_id' => Yii::t('app', 'Model ID'),
            'user_id' => Yii::t('app', 'User'),
            'name' => Yii::t('app', 'Name'),
            'content' => Yii::t('app', 'Content'),
            'tree' => Yii::t('app', 'Tree'),
            'lft' => Yii::t('app', 'Lft'),
            'rgt' => Yii::t('app', 'Rgt'),
            'depth' => Yii::t('app', 'Depth'),
            'status_id' => Yii::t('app', 'Status'),
            'published' => Yii::t('app', 'Published'),
            'position' => Yii::t('app', 'Position'),
        ];
    }
}
