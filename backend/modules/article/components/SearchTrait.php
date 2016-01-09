<?php

namespace backend\modules\article\components;

use yii\base\Model;

/**
 * Trait SearchTrait
 * @package backend\modules\article\components
 */
trait SearchTrait
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'published', 'show_on_main'], 'integer'],
            [['label', 'alias', 'announce', 'content', 'date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
}
