<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Activity;
use frontend\models\ActivityCate;

/**
 * ActivitySearch represents the model behind the search form of `frontend\models\Activity`.
 */
class ActivitySearch extends Activity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ac_id', 'cate_id', 'type_id', 'side_id', 'ac_name'], 'safe'],
            [['ac_num', 'ac_time'], 'integer'],
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
            $query = Activity::find()->orderBy(['ac_id'=>SORT_ASC]);
        }
        // $query->leftJoin('activity_cate','activity_cate.cate_id=activity.cate_id');
        // $query->leftJoin('activity_type','activity_type.type_id=activity.type_id');
        // $query->leftJoin('activity_side','activity_side.side_id=activity.side_id');

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
            'ac_num' => $this->ac_num,
            'ac_time' => $this->ac_time,
            'cate_id'=>$this->cate_id,
            'type_id'=>$this->type_id,
            'side_id'=>$this->side_id
        ]);

        $query->andFilterWhere(['like', 'ac_id', $this->ac_id])
            // ->andFilterWhere(['like', 'activity_cate.cate_name', $this->cate_id])
            // ->andFilterWhere(['like', 'activity_type.type_name', $this->type_id])
            // ->andFilterWhere(['like', 'activity_side.side_name', $this->side_id])
            ->andFilterWhere(['like', 'ac_name', $this->ac_name])
            ;

        return $dataProvider;
    }
}
