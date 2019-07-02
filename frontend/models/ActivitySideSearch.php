<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ActivitySide;

/**
 * ActivitySideSearch represents the model behind the search form of `frontend\models\ActivitySide`.
 */
class ActivitySideSearch extends ActivitySide
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['side_id', 'side_name'], 'safe'],
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
            $query = ActivitySide::find()->orderBy(['side_id'=>SORT_ASC]);
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
        $query->andFilterWhere(['like', 'side_id', $this->side_id])
            ->andFilterWhere(['like', 'side_name', $this->side_name]);

        return $dataProvider;
    }
}
