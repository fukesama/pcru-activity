<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Branch;

/**
 * BrachSearch represents the model behind the search form of `frontend\models\Branch`.
 */
class BrachSearch extends Branch
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_id', 'branch_name', 'faculty_id'], 'safe'],
            [['edub_id'], 'integer'],
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
            $query = Branch::find()->orderBy(['branch_id'=>SORT_ASC]);

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
            'edub_id' => $this->edub_id,
        ]);

        $query->andFilterWhere(['like', 'branch_id', $this->branch_id])
            ->andFilterWhere(['like', 'branch_name', $this->branch_name])
            ->andFilterWhere(['like', 'faculty_id', $this->faculty_id]);

        return $dataProvider;
    }
}
