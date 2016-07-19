<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Users;

/**
 * CarSearch represents the model behind the search form about `common\models\Car`.
 */
class SearchUser extends Users
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'role_id','cat_id','cat_level'], 'integer'],
            [['username','email','created_at'], 'string', 'max' => 255],
            // return ['id', 'role_id','cat_id','cat_level','username', 'email','password_hash','auth_key','confirmed_at','created_at','updated_at','flags','user_info','registration_ip','password_reset_token'
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Порядоковый номер',
            'created_at' => 'Дата создания',
            'username' => 'Логин',
            'email' => 'Email',
        ];
    }
    /**
     * Creates data provider instance with search query applied
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Users::find()->where(['flags'=>0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}