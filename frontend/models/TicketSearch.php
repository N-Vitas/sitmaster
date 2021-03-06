<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Ticket;
use common\models\Group;

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
            [['id','user_id', 'agent_id', 'updated_at', 'closed_at'], 'integer'],
            [['text', 'json','files','callback'], 'string'],
            [['status','created_at','priorited', 'cat_level', 'cat_id'],'safe'],
            [['title'], 'string', 'max' => 255],
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
        $group = \Yii::$app->user->identity->getGroups();        
        switch (\Yii::$app->user->identity->role_id) {
            case 1:
                if($group){
                    foreach ($group as $item) {
                        $query = Ticket::find()->where(['cat_id' => $item->id]);                 
                    }
                }else{
                    $query = Ticket::find()->where(['cat_id' => 0]);                 
                }
                break;
            case 2:
                foreach ($group as $item) {
                    $id[] = $item->id;                                  
                }
                $query = Ticket::find()->where(['in','cat_id',$id]); 
                foreach ($group as $top) {
                    if($top->level)
                        $id[] = $top->id;
                    else{
                        $id[] = $top->id;
                        $items = Group::find()->where(['level'=>$top->id])->all();
                        foreach($items AS $item)
                            $id[] = $item->id;
                    }                                   
                }
                $query = Ticket::find()->where(['in','cat_id',$id]);  
                break;
            case 3:
                foreach ($group as $top) {
                    if($top->level)
                        $id[] = $top->id;
                    else{
                        $id[] = $top->id;
                        $items = Group::find()->where(['level'=>$top->id])->all();
                        foreach($items AS $item)
                            $id[] = $item->id;
                    }                                   
                }
                $query = Ticket::find()->where(['in','cat_id',$id]);  
                break;           
            default:
                $query = Ticket::find();
                break;
        }

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
        // echo '<pre>';var_dump($this);die;
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'agent_id' => $this->agent_id,
            'text' => $this->text,
            'title' => $this->title,
        ]); 
        // var_dump($this->status);die;
        if(is_array($this->cat_id) and is_array($this->cat_level)){
            $cat_id = array_merge($this->cat_id,$this->cat_level);
            $query->andFilterWhere(['in','cat_id',$cat_id]);
        }else{  
            if(is_array($this->cat_level)){
                $query->andFilterWhere(['in','cat_id',$this->cat_level]);
                // echo '<pre>';var_dump($cat_id);die;
            }       
            if(is_array($this->cat_id)){
                $query->andFilterWhere(['in','cat_id',$this->cat_id]);
            }     
        }        

        if(is_array($this->status)){
            $query->andFilterWhere(['in','status',$this->status]);
        }       
        if(is_array($this->priorited)){
            $query->andFilterWhere(['in','priorited',$this->priorited]);
        }
        if($this->created_at && !is_numeric($this->created_at)){
            switch ($this->created_at) {
                case 'all_time':
                    break;
                case 'today_time':
                    $query->andFilterWhere(['>=','created_at',mktime(0,0,0)]);                    
                    break;
                case 'yesterday':
                    $query->andFilterWhere(['>=','created_at',mktime(0,0,0)-86400]);
                    $query->andFilterWhere(['<=','created_at',mktime(0,0,0)]);
                    break;
                case 'this_week':
                    $query->andFilterWhere(['>=','created_at',strtotime("last Monday")]);
                    break;
                case 'last_week':
                    $query->andFilterWhere(['>=','created_at',strtotime("last Monday")-86400*7]);
                    $query->andFilterWhere(['<=','created_at',strtotime("last Monday")]);
                    break;
                case 'this_month':                
                    $query->andFilterWhere(['>=','created_at',strtotime('1 '.date('M').' '.date('Y'))]);
                    break;
                case 'last_month':
                    $query->andFilterWhere(['<=','created_at',strtotime('1 '.date('M').' '.date('Y'))]);
                    break;    
            }
        }else{
            $query->andFilterWhere(['created_at' => $this->created_at]);
        }

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'title', $this->title]);
        // echo '<pre>';var_dump($query);die;
        return $dataProvider;
    }
}