<?php

namespace frontend\modules\article\models;

use common\components\Translate;
use common\models\Comment;
use yii\db\Query;

/**
 * Class Article
 * @package frontend\modules\article\models
 */
class Article extends \common\models\Article {
    use Translate;

    const PAGE_SIZE = 5;

    /** @return array */
    public function getTagsArray()
    {
        return explode(', ', $this->tags);
    }

    /** @return integer */
    public function getCommentsCount()
    {
        return (new Query())
            ->from(Comment::tableName())
            ->andWhere([
                'model_name' => static::formName(),
                'model_id' => $this->id,
                'published' => 1
            ])
            ->andWhere('depth > 0')
            ->count();
    }

    /** @return array */
    public function getBreadcrumbsLinks()
    {
        if ($this->category) {
            return [
                [
                    'label' => $this->category->label,
                    'url' => $this->category->getIndexUrl()
                ],
                [
                    'label' => $this->label,
                ]
            ];
        }

        return [
            [
                'label' => $this->label,
            ]
        ];
    }
}
