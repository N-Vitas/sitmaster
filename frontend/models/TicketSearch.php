<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Ticket;

/**
 * OrderSearch represents the model behind the search form about `common\models\Ticket`.
 */
class TicketSearch extends Ticket
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','user_id', 'agent_id', 'cat_level', 'cat_id', 'created_at', 'updated_at', 'closed_at', 'status'], 'integer'],
            [['text', 'json','files','callback'], 'string'],
            [['title', 'priorited'], 'string', 'max' => 255],
            // ['verifyCode', 'captcha'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Ticket::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

               
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'user_id' => $this->user_id,
            'agent_id' => $this->agent_id,
            'cat_level' => $this->cat_level,
            'cat_id' => $this->cat_id,
            'status' => $this->status,
            'text' => $this->text,
            'title' => $this->title,
            'priorited' => $this->priorited,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'priorited', $this->priorited])
            ->andFilterWhere(['like', 'status', $this->status]);
        // echo '<pre>';var_dump($query);die;
        return $dataProvider;
    }
}