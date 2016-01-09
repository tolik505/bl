<?php

namespace frontend\widgets\popularPosts;

use frontend\modules\article\models\Article;
use yii\base\Widget;

class PopularPostsWidget extends Widget
{

    public function run()
    {
        $models = Article::find()
            ->joinWith(['titleImage'])
            ->isPublished()
            ->orderBy('views DESC')
            ->limit(3)
            ->all();

        if (empty($models)) {
            return false;
        }

        return $this->render('default', [
            'models' => $models,
        ]);
    }
}
