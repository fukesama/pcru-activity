<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ActivityEnter;

/**
 * ActivityEnterSearch represents the model behind the search form of `backend\models\ActivityEnter`.
 */
class ActivityEnterSearch extends ActivityEnter
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
    	return [
    		[['acen_id', 'acoyd_id', 'co_id','faculty_id','branch_id'], 'integer'],
    		[['enter_status', 'result',], 'safe'],
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
    		$query = ActivityEnter::find()
    		->joinWith('acoyd')
    		->joinWith('acoyd.acoy as acoy')
    		->joinWith('acoyd.acoy.ac as ac')
    		->joinWith('co as co')
    		->joinWith('co.fac as fac')
    		->joinWith('co.bra as bra');
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
    		'acen_id' => $this->acen_id,
    		'co.faculty_id' => $this->faculty_id,
    		'co.branch_id' => $this->branch_id,
    		'acoyd_id' => $this->acoyd_id,
    		'co_id' => $this->co_id,
    	]);

    	$query->andFilterWhere(['like', 'enter_status', $this->enter_status])
    	->andFilterWhere(['like', 'result', $this->result]);

    	return $dataProvider;
    }
}
