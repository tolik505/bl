<?php
/**
 * Author: metal
 * Email: metal
 */

namespace common\components\model;

use yii\db\ActiveQuery;

/**
 * Class DefaultQuery
 * @package common\models
 */
class DefaultQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function isPublished()
    {
        $this->andWhere(['published' => true]);

        return $this;
    }
}
