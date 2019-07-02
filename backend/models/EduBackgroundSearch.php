<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EduBackground;

/**
* EduBackgroundSearch represents the model behind the search form of `backend\models\EduBackground`.
*/
class EduBackgroundSearch extends EduBackground
{
    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['edub_id', 'edub_code', 'edub_name'], 'safe'],
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
            $query = EduBackground::find()->orderBy(['edub_id'=>SORT_ASC]);
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
        $query->andFilterWhere(['like', 'edub_id', $this->edub_id])
        ->andFilterWhere(['like', 'edub_code', $this->edub_code])
        ->andFilterWhere(['like', 'edub_name', $this->edub_name]);

        return $dataProvider;
    }
}
