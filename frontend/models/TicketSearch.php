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
            [['id','user_id', 'agent_id', 'cat_level', 'cat_id', 'updated_at', 'closed_at'], 'integer'],
            [['text', 'json','files','callback'], 'string'],
            [['status','created_at'],'safe'],
            [['title', 'priorited'], 'string', 'max' => 255],
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
        // var_dump($this->attributes);
               
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'agent_id' => $this->agent_id,
            'cat_level' => $this->cat_level,
            'cat_id' => $this->cat_id,
            'text' => $this->text,
            'title' => $this->title,
            'priorited' => $this->priorited,
        ]);        
        if(is_array($this->status)){
            $query->andFilterWhere(['in','status',$this->status]);
        }

        // var_dump($this->created_at);die;
        if($this->created_at && !is_numeric($this->created_at)){
            switch ($this->created_at) {
                case 'all_time':
                    break;
                case 'today_time':
                    $query->andFilterWhere(['>=','created_at',(time()-86400)]);                    
                    break;
                // case 'yesterday':
                //     $query->andFilterWhere(['created_at',$this->created_at]);
                //     break;
                case 'this_week':
                    $query->andFilterWhere(['>=','created_at',(time()-86400*7)]);
                    break;
                // case 'last_week':
                //     $query->andFilterWhere(['created_at',$this->created_at]);
                //     break;
                // case 'this_month':
                //     $query->andFilterWhere(['created_at',$this->created_at]);
                //     break;
                // case 'last_month':
                //     $query->andFilterWhere(['created_at',$this->created_at]);
                //     break;                
                // default:
                //     $query->andFilterWhere(['created_at',$this->created_at]);
                //     break;
            }
            // $date = strtotime($this->created_at);
            // $query->andFilterWhere(['>=','created_at',$date]);
            // $query->andFilterWhere(['<=','created_at',$date+86400]);
        }else{
            $query->andFilterWhere(['created_at' => $this->created_at]);
        }

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'priorited', $this->priorited]);
        // echo '<pre>';var_dump($query);die;
        return $dataProvider;
    }
}