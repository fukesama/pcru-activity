<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ActivityOfyear;

/**
* ActivityOfyearSearch represents the model behind the search form of `frontend\models\ActivityOfyear`.
*/
class ActivityOfyearSearch extends ActivityOfyear
{
    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['acoy_id', 'year', 'ac_id', 'ac_startdate', 'ac_enddate', 'ac_starttime', 'ac_endtime', 'address_detail'], 'safe'],
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
    public function search($params,$query=null)
    {
        if($query==null){
            $query = ActivityOfyear::find();
        }

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
            'ac_startdate' => $this->ac_startdate,
            'ac_enddate' => $this->ac_enddate,
            'ac_starttime' => $this->ac_starttime,
            'ac_endtime' => $this->ac_endtime,
        ]);

        $query->andFilterWhere(['like', 'acoy_id', $this->acoy_id])
        ->andFilterWhere(['like', 'year', $this->year])
        ->andFilterWhere(['like', 'ac_id', $this->ac_id])
        ->andFilterWhere(['like', 'address_detail', $this->address_detail]);

        return $dataProvider;
    }
}
