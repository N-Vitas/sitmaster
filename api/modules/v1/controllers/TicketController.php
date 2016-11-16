<?php

namespace api\modules\v1\controllers;

use Yii;
use common\models\Ticket;
use common\models\Group;
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
        $items = Group::find()->where(['!=','level',0])->all();
        break;
  	}
	  $result['ticket'] = $query->all();  
	  $result['group'] = $group;
	  isset($items)?$result['childGroup'] = $items:$result['childGroup'] = false;	
	  $result['statusNames'] = Ticket::$statusNames;
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
	  	// if($comments){
	  	// 	foreach ($comments as $comment) {
	  	// 		$profiles[] = $comment->getProfile();
	  	// 	}
	  	// }
	  	$res = [
	  		'ticket' => $ticket,
				'comments' => $comments,
	  	];
	  	return $res;  		
  	}
  	throw new \yii\base\Exception( "Данной заявки не найдено.",404);
  }

  public function actionCreate(){
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
}
?>