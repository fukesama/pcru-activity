<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ActivityEnterDetail;

/**
 * ActivityEnterDetailSearch represents the model behind the search form of `backend\models\ActivityEnterDetail`.
 */
class ActivityEnterDetailSearch extends ActivityEnterDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['acend_id', 'acen_id'], 'integer'],
            [['qrcode', 'acend_date'], 'safe'],
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
        $query = ActivityEnterDetail::find();

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
            'acend_id' => $this->acend_id,
            'acen_id' => $this->acen_id,
            'acend_date' => $this->acend_date,
        ]);

        $query->andFilterWhere(['like', 'qrcode', $this->qrcode]);

        return $dataProvider;
    }
}
