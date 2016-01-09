<?php

namespace common\models;

use Yii;

/**
 * @inheritdoc
 *
 * @property EntityToFile[] $entityToFiles
 */
class FpmFile extends \common\models\base\FpmFile
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntityToFiles()
    {
        return $this->hasMany(EntityToFile::className(), ['file_id' => 'id']);
    }

}
