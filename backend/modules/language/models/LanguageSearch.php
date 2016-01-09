<?php

namespace backend\modules\language\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LanguageSearch represents the model behind the search form about `backend\modules\language\models\Language`.
 */
class LanguageSearch extends Language
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'published', 'is_default'], 'integer'],
            [['label', 'code', 'locale'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Language::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'published' => $this->published,
            'is_default' => $this->is_default,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'locale', $this->locale]);

        return $dataProvider;
    }
}
