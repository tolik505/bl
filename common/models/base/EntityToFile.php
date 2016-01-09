<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "entity_to_file".
 *
 * @property integer $id
 * @property string $entity_model_name
 * @property integer $entity_model_id
 * @property integer $file_id
 * @property string $temp_sign
 * @property string $attribute
 * @property integer $position
 */
abstract class EntityToFile extends \common\components\model\ActiveRecord
{
    const TYPE_ARTICLE_TITLE_IMAGE = 'article_title_image';


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entity_to_file';
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
            [['entity_model_name', 'entity_model_id', 'file_id'], 'required'],
            [['entity_model_id', 'file_id', 'position'], 'integer'],
            [['entity_model_name', 'temp_sign'], 'string', 'max' => 255],
            [['file_id'], 'exist', 'targetClass' => \common\models\FpmFile::className(), 'targetAttribute' => 'id'],
            [['temp_sign'], 'default', 'value' => ''],
            [['position'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity_model_name' => 'Entity Model Name',
            'entity_model_id' => 'Entity Model ID',
            'file_id' => 'File ID',
            'temp_sign' => 'Temp Sign',
            'position' => 'Position',
        ];
    }

    /**
     * @param $entityName
     * @param $entityId
     * @param $fileId
     * @param null $sign
     * @param null $attribute
     * @param null $isGUID
     *
     * @return bool|EntityToFile
     */
    public static function add($entityName, $entityId, $fileId, $sign = null, $attribute = null)
    {
        $model = new \common\models\EntityToFile();
        $model->file_id = (int)$fileId;
        $model->entity_model_name = $entityName;
        if ($sign) {
            $model->temp_sign = $sign;
            $model->entity_model_id = 0;
        } else {
            $model->entity_model_id = $entityId ? $entityId : 0;
        }

        if ($attribute !== null) {
            $model->attribute = $attribute;
        }

        if ($model->save()) {
            return $model;
        }

        return false;
    }

    /**
     * @param $entityModelName
     * @param $entityModelId
     */
    public static function deleteImages($entityModelName, $entityModelId)
    {
        static::deleteAll(
            'entity_model_name = :enm AND entity_model_id = :emi',
            [':enm' => $entityModelName, ':emi' => $entityModelId]
        );
    }

    public static function updateImages($model_id, $sign)
    {
        \Yii::$app->db->createCommand()
            ->update(
                EntityToFile::tableName(),
                [
                    'entity_model_id' => $model_id,
                    'temp_sign' => ''
                ],
                'temp_sign = :ts',
                [':ts' => $sign]
            )
            ->execute();
    }
}
