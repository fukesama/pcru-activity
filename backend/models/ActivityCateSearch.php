<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ActivityCate;

/**
 * ActivityCateSearch represents the model behind the search form of `backend\models\ActivityCate`.
 */
class ActivityCateSearch extends ActivityCate
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cate_id', 'cate_name'], 'safe'],
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
            $query = ActivityCate::find()->orderBy(['cate_id'=>SORT_ASC]);
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
        $query->andFilterWhere(['like', 'cate_id', $this->cate_id])
            ->andFilterWhere(['like', 'cate_name', $this->cate_name]);

        return $dataProvider;
    }
}
