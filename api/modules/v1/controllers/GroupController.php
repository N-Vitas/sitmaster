<?php

namespace api\modules\v1\controllers;

use Yii;
use common\models\Ticket;
use common\models\Group;
use common\models\UserGroup;
use common\models\CommentTicket;
use api\components\Controller;
use yii\data\ActiveDataProvider;


class GroupController extends Controller
{
  public function actionIndex()
  {
    return Group::find()->where(['level'=>0])->all();
  }

  public function actionCreate(){  	
  	$model = new Group();
    if ($model->load(Yii::$app->request->post()) && $model->save()){
      return $model;
    }else{
    	return $model->errors;
    }
  	throw new \yii\base\Exception( "Требуется ввод данных посредством POST.",405);
  }

  public function actionUpdate($id){  	
  	$model = Group::findOne($id);
    if($model->load(Yii::$app->request->post()) && $model->save()){
      return $model;
    }else{
    	return $model->errors;
    }
  	throw new \yii\base\Exception( "Требуется ввод данных посредством POST.",405);
  }

  public function actionDelete($id){  	
  	if(Group::deleteAll(['id'=>$id])){
      UserGroup::deleteAll(['group_id'=>$id]);
      Ticket::deleteAll(['cat_id'=>$id]);
      return ['result'=>true];
    }
  	return ['result'=>false];
  }
  
}
?>