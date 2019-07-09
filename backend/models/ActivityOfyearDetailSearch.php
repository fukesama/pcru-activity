<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ActivityOfyearDetail;

/**
 * ActivityOfyearDetailSearch represents the model behind the search form of `backend\models\ActivityOfyearDetail`.
 */
class ActivityOfyearDetailSearch extends ActivityOfyearDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
    	return [
    		[['acoyd_id'], 'integer'],
    		[['acoy_id', 'ac_startdate', 'ac_enddate', 'address_detail', 'detail','year','ac_id'], 'safe'],
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
    		$query = ActivityOfyearDetail::find();
    	}
    	$query->innerJoinWith('acoy as acoy');
    	$query->innerJoinWith('acoy.ac as ac');

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
    		'acoyd_id' => $this->acoyd_id,
    		'ac.ac_id' => $this->ac_id,
            // 'ac_startdate' => $this->ac_startdate,
            // 'ac_enddate' => $this->ac_enddate,
    	]);

    	$query->andFilterWhere(['like', 'acoy_id', $this->acoy_id])
    	->andFilterWhere(['like', 'address_detail', $this->address_detail])
    	->andFilterWhere(['like', 'detail', $this->detail])
    	->andFilterWhere(['like', 'ac_startdate', $this->year]);

    	return $dataProvider;
    }
}
