<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ActivityEnter;

/**
 * ActivityEnterSearch represents the model behind the search form of `backend\models\ActivityEnter`.
 */
class ActivityEnterReportSearch extends Viewenter
{
	public $acen_id;
	public $number;
	public $ver;
	public $group;
	public $acoyd_id;
	public $co_id;
	public $branch_id;
	public $faculty_id;
	public $enter_status;
	public $result;
	public $pre_name;
	public $uc_fname;
	public $uc_lname;
	public $co_name;	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
    	return [
    		[['acen_id', 'acoyd_id', 'co_id','faculty_id','branch_id','number'], 'integer'],
    		[['enter_status','acoyd_id', 'result','ver','pre_name','group','uc_fname','uc_lname','co_name',], 'safe'],
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
    		$query = Viewenter::find()    		
    		// ->innerJoin(['acoyd'=>'activity_ofyear_detail'],'activity_enter.acoyd_id=acoyd.acoyd_id')
    		// ->innerJoin(['acoy'=>'activity_ofyear'],'acoyd.acoy_id=acoy.acoy_id')
    		// ->innerJoin(['ac'=>'activity'],'acoy.ac_id=ac.ac_id')
    		// ->innerJoin(['co'=>'user_collegian'],'activity_enter.co_id=co.user_id')
    		// ->innerJoin(['fac'=>'faculty'],'co.faculty_id=fac.faculty_id')
    		// ->innerJoin(['bra'=>'branch'],'co.branch_id=bra.branch_id')
    		// ->innerJoin(['pre'=>'prefix'],'co.pre_id=pre.pre_id')
    		// ->joinWith('acoyd as acoyd')
    		// ->joinWith('acoyd.acoy as acoy')
    		// ->joinWith('acoyd.acoy.ac as ac')
    		// ->joinWith('co as co')
    		// ->joinWith('co.fac as fac')
    		// ->joinWith('co.bra as bra')
    		// ->joinWith('co.fac as fac')
    		;
    	}


        // add conditions that should always apply here

    	$dataProvider = new ActiveDataProvider([
    		'query' => $query,
    		'pagination'=>[
    			'pageSize'=>10
    		]
    		
    	]);

    	$this->load($params);


    	if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
    		return $dataProvider;
    	}

        // grid filtering conditions
    	// $query->andFilterWhere([
    	// 	'acen_id' => $this->acen_id,    	
    	// 	'acoyd.acoyd_id' => $this->acoyd_id,
    	// 	'co.faculty_id' => $this->faculty_id,
    	// 	'co.branch_id' => $this->branch_id,    		
    	// 	'co.ver' => $this->ver,
    	// 	'co.group' => $this->group,
    	// 	'co_id' => $this->co_id,
    	// ]);
    	// $name=explode(' ',$this->co_name);

    	// $query->andFilterWhere(['like', 'enter_status', $this->enter_status])

    	// ->andFilterWhere(['like', 'result', $this->result])
    	// ->andFilterWhere(['like', 'co.number', $this->number])
    	// ->andFilterWhere(['like', 'pre.pre_name',$this->pre_name])
    	// ->andFilterWhere(['like', 'co.uc_fname',$this->uc_fname])
    	// ->andFilterWhere(['like', 'co.uc_lname',$this->uc_lname]);

    	$query->andFilterWhere([
    		'acen_id' => $this->acen_id,    	
    		'acoyd_id' => $this->acoyd_id,
    		'faculty_id' => $this->faculty_id,
    		'branch_id' => $this->branch_id,    		
    		'ver' => $this->ver,
    		'group' => $this->group,
    		'co_id' => $this->co_id,
    	]);
    	$name=explode(' ',$this->co_name);

    	$query->andFilterWhere(['like', 'enter_status', $this->enter_status])

    	->andFilterWhere(['like', 'result', $this->result])
    	->andFilterWhere(['like', 'number', $this->number])
    	->andFilterWhere(['like', 'pre.pre_name',$this->pre_name])
    	->andFilterWhere(['like', 'uc_fname',$this->uc_fname])
    	->andFilterWhere(['like', 'uc_lname',$this->uc_lname]);

    	return $dataProvider;
    }
}
