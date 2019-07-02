<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\User;
use common\models\User as User2;

/**
* UserSearch represents the model behind the search form of `frontend\models\User`.
*/
class UserSearch extends User
{
    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email','level_user'], 'safe'],
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
    public function search($params,$data=['query'=>null,'page'=>10])
    {
        $query=$data['query'];
        if($query===null){
            //$query = User::find()->where('level_user!=:a or level_user=null',['a'=>User2::ADMIN]);
            $query = User::find();
        }
        else{
            $query->where('level_user!=:a or level_user=null',['a'=>User2::ADMIN]);
        }



        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $data['page'],
                'pageParam' => 'all-post',
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'level_user' => $this->level_user,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
        ->andFilterWhere(['like', 'auth_key', $this->auth_key])
        ->andFilterWhere(['like', 'password_hash', $this->password_hash])
        ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
        ->andFilterWhere(['like', 'email', $this->email]);


        return $dataProvider;
    }
}
