<?php

namespace common\models;

use notgosu\yii2\modules\metaTag\components\MetaTagRegister;
use Yii;

/**
 * @inheritdoc
 */
class PageSeo extends \common\models\base\PageSeo
{
    const ID_HOME_PAGE = 1;


    /** @param int $pageSeoId */
    public static function registerSeo($pageSeoId)
    {
        $model = PageSeo::find()
            ->andWhere(['id' => $pageSeoId])
            ->one();
        if ($model){
            MetaTagRegister::register($model);
        }
    }
}
