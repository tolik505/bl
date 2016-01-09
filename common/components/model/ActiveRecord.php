<?php

namespace common\components\model;

/**
 * Class ActiveRecord
 * @package common\components\model
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    use Helper;

    /**
     * @inheritdoc
     * @return DefaultQuery
     */
    public static function find()
    {
        return new DefaultQuery(get_called_class());
    }
}
