<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\UserCollegian;

/**
 * UserCollegianSearch represents the model behind the search form of `frontend\models\UserCollegian`.
 */
class UserCollegianSearch extends UserCollegian
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['pre_id', 'uc_fname', 'uc_lname', 'faculty_id', 'branch_id', 'address'], 'safe'],
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
            $query = UserCollegian::find();
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
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'pre_id', $this->pre_id])
            ->andFilterWhere(['like', 'uc_fname', $this->uc_fname])
            ->andFilterWhere(['like', 'uc_lname', $this->uc_lname])
            ->andFilterWhere(['like', 'faculty_id', $this->faculty_id])
            ->andFilterWhere(['like', 'branch_id', $this->branch_id])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
