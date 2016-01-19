<?php

namespace frontend\widgets\footerSitemap;

use yii\base\Widget;

class FooterSitemapWidget extends Widget
{

    public function run()
    {
        $models = \Yii::$app->params['categoryModels'];

        $countModels = count($models);

        if (!$countModels) {
            return false;
        }
        $md = 6 - $countModels;

        return $this->render('default', [
            'models' => $models,
            'md' => $md ? $md : 1,
        ]);
    }
}
