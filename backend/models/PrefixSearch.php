<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Prefix;

/**
 * PrefixSearch represents the model behind the search form of `backend\models\Prefix`.
 */
class PrefixSearch extends Prefix
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pre_id', 'pre_name'], 'safe'],
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
            $query = Prefix::find()->orderBy(['pre_id'=>SORT_ASC]);
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
        $query->andFilterWhere(['like', 'pre_id', $this->pre_id])
            ->andFilterWhere(['like', 'pre_name', $this->pre_name]);

        return $dataProvider;
    }
}
