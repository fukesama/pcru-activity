<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ActivityType;

/**
 * ActivityTypeSearch represents the model behind the search form of `backend\models\ActivityType`.
 */
class ActivityTypeSearch extends ActivityType
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'type_name'], 'safe'],
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
            $query = ActivityType::find()->orderBy(['type_id'=>SORT_ASC]);
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
        $query->andFilterWhere(['like', 'type_id', $this->type_id])
            ->andFilterWhere(['like', 'type_name', $this->type_name]);

        return $dataProvider;
    }
}
