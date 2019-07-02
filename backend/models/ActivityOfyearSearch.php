<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ActivityOfyear;

/**
 * ActivityOfyearSearch represents the model behind the search form of `backend\models\ActivityOfyear`.
 */
class ActivityOfyearSearch extends ActivityOfyear
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['acoy_id', 'ac_id', 'edu_level'], 'safe'],
            [['point'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = ActivityOfyear::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'point' => $this->point,
        ]);

        $query->andFilterWhere(['like', 'acoy_id', $this->acoy_id])
            ->andFilterWhere(['like', 'ac_id', $this->ac_id])
            ->andFilterWhere(['like', 'edu_level', $this->edu_level]);

        return $dataProvider;
    }
}
