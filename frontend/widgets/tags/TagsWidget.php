<?php

namespace frontend\widgets\tags;

use frontend\modules\article\models\Article;
use justinvoelker\tagging\TaggingQuery;
use yii\base\Widget;

class TagsWidget extends Widget
{

    public function run()
    {
        $query = new TaggingQuery();
        $tags = $query
            ->select('tags')
            ->from(Article::tableName())
            ->delimiter(', ')
            ->getTags();

        if (empty($tags)) {
            return false;
        }

        return $this->render('default', [
            'tags' => $tags,
        ]);
    }
}
