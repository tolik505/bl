<?php

namespace frontend\modules\article\widgets\articleTags;

use frontend\modules\article\models\Article;

class ArticleTagsWidget extends \yii\base\Widget
{
    /** @var  Article */
    public $model;

    public function run()
    {
        if (!$this->model || !$this->model->tags) {
            return false;
        }

        return $this->render('default', ['tags' => $this->model->getTagsArray()]);
    }
}
