<?php

namespace api\modules\v1\controllers;

use Yii;
use common\models\Ticket;
use common\models\Group;
use common\models\UserGroup;
use common\models\CommentTicket;
use api\components\Controller;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;


class TicketController extends Controller
{
  public function actionIndex()
  {
    return Ticket::find()->all();
  }

  public function actionGroup(){
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
	  $result['ticket'] = $query->all();  
	  $result['group'] = $group;
	  return $result;
  }

  public function actionItem($id){
  	$ticket = Ticket::find()->where('id=:id',[':id' => $id])->one();
  	if($ticket){
  		$query = CommentTicket::find();
	    // $query->with(['profile']);
	    $query->where('{{comment_ticket}}.ticket_id = :ticket_id', [':ticket_id'=> $ticket->id]);
	    $query->orderBy('{{comment_ticket}}.created_at');
	  	$comments = $query->all();
	  	$res = [
	  		'ticket' => $ticket,
				'comments' => $comments,
	  	];
	  	return $res;  		
  	}
  	throw new \yii\base\Exception( "Данной заявки не найдено.",404);
  }

  public function actionCreate(){
    // var_dump($_POST,$_FILES);die;
  	$model = new Ticket(['user_id'=>\Yii::$app->user->id]);
    if ($model->load(Yii::$app->request->post())) {
      $model->file = UploadedFile::getInstance($model, 'file');

      if($model->file && $model->save()){
        $model->file->saveAs('uploads/' . $model->file->baseName . '.' . $model->file->extension);
	    	$model->sendEmail(Yii::$app->params['adminEmail']);
      }
      else if($model->save()){
        $model->sendEmail(Yii::$app->params['adminEmail']);
      }
      return $model;
    }else{
    	return $model->errors;
    }
  	throw new \yii\base\Exception( "Требуется ввод данных посредством POST.",405);
  }

  public function actionAnalityc(){
  	$levelUp = Group::find()->where(['level'=>0])->all();
    foreach ($levelUp as $group) {
      if(UserGroup::find()->where(['user_id'=>Yii::$app->user->identity->id,'group_id'=>$group->id])->count()){
        $leveDown = Group::find()->where(['level'=>$group->id])->all();
        $open  = Ticket::find()->where(['cat_id'=>$group->id,'status'=>1])->count();
        $wait  = Ticket::find()->where(['cat_id'=>$group->id,'status'=>2])->count();
        $stop  = Ticket::find()->where(['cat_id'=>$group->id,'status'=>3])->count();
        $close = Ticket::find()->where(['cat_id'=>$group->id,'status'=>4])->count();
        $total = Ticket::find()->where(['cat_id'=>$group->id])->count();
        $statistic[] = [
          'title' => $group->title,
          'open'  => $open,
          'wait'  => $wait,
          'stop'  => $stop,
          'close' => $close,
          'total' => $total,
        ]; 
        foreach ($leveDown as $down) {
          $l_open  = Ticket::find()->where(['cat_id'=>$down->id,'status'=>1])->count();
          $l_wait  = Ticket::find()->where(['cat_id'=>$down->id,'status'=>2])->count();
          $l_stop  = Ticket::find()->where(['cat_id'=>$down->id,'status'=>3])->count();
          $l_close = Ticket::find()->where(['cat_id'=>$down->id,'status'=>4])->count();
          $l_total = Ticket::find()->where(['cat_id'=>$down->id])->count();
          $statistic[] = [
            'title' => $down->title,
            'open'  => $l_open,
            'wait'  => $l_wait,
            'stop'  => $l_stop,
            'close' => $l_close,
            'total' => $l_total,
          ];             
          $open  += $l_open;
          $wait  += $l_wait;
          $stop  += $l_stop;
          $close += $l_close;
          $total += $l_total;
        } 
        $statistic[] = [
          'title' => '(Общее) '.$group->title,
          'open'  => $open,
          'wait'  => $wait,
          'stop'  => $stop,
          'close' => $close,
          'total' => $total,
        ]; 
        unset($open);
        unset($wait);
        unset($stop);
        unset($close);
        unset($total);
	    }
	  }
	  if(count($statistic))
	    return $statistic;
	  throw new \yii\base\Exception( "У вас нет прав для просмотра данной информации.",403);
  }
}
?>