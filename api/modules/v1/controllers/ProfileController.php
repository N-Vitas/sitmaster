<?php

namespace api\modules\v1\controllers;

use Yii;
use common\models\Profile;
use common\models\User;
use api\components\Controller;
use yii\data\ActiveDataProvider;


class ProfileController extends Controller
{
  public function actionIndex()
  {
    return Profile::findOne(\Yii::$app->user->id);
  }
  
  public function actionCreate(){
  	$model = new \frontend\models\SignupForm();
    if ($model->load(Yii::$app->request->post())) {
      if ($user = $model->signup()) {
        return $user;
      }
    }

    return $model->errors;    
  }

  public function actionUpdate($id)
  {
    //Если есть id и роль админ 
    if($id && Yii::$app->user->identity->role_id > 3){
      if(Yii::$app->request->post("phone") && $id){
      $profile = Profile::find()->where('user_id = :user_id',[':user_id'=>$id])->one();
        if($profile){
          $profile->phone = Yii::$app->request->post("phone");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("name") && $id){
        $profile = Profile::find()->where('user_id = :user_id',[':user_id'=>$id])->one();
        if($profile){
          $profile->name = Yii::$app->request->post("name");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("location") && $id){
        $profile = Profile::find()->where('user_id = :user_id',[':user_id'=>$id])->one();
        if($profile){
          $profile->location = Yii::$app->request->post("location");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("username") && $id){
        $profile = User::find()->where('id=:id',[':id'=>$id])->one();
        if($profile){
          $profile->username = Yii::$app->request->post("username");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("email") && $id){
        $user = User::find()->where('id=:id',[':id'=>$id])->one();
    		$profile = Profile::find()->where('user_id = :user_id',[':user_id'=>$id])->one();
        if($profile){
          $user->email = Yii::$app->request->post("email");
    			$profile->public_email = Yii::$app->request->post("email",$profile->public_email);
          $user->save();
          $profile->save();
        }
      }
      if(Yii::$app->request->post("role") && $id){
        $profile = User::find()->where('id=:id',[':id'=>$id])->one();
        if($profile){
          $profile->role_id = Yii::$app->request->post("role");
          $profile->save();
        }
      }
      $profile = Profile::findOne($id);
    }else{
    	$profile = Profile::find()->where('user_id = :user_id',[':user_id'=>Yii::$app->user->id])->one();
    	$user = User::findOne(Yii::$app->user->id);

    	$profile->phone = Yii::$app->request->post("phone",$profile->phone);
    	$profile->name = Yii::$app->request->post("name",$profile->name);
    	$profile->location = Yii::$app->request->post("location",$profile->location);
    	$profile->public_email = Yii::$app->request->post("email",$profile->public_email);
    	$user->username = Yii::$app->request->post("username",$user->username);
    	$user->email = Yii::$app->request->post("email",$user->email);
    	if(!empty(Yii::$app->request->post("password"))){
    		$user->setPassword(Yii::$app->request->post("password"));
    	}
    	
      if(!$profile->save()){
        return $profile->errors;
      }
      if(!$user->save()){
        return $user->errors;
      }
    }
    return $profile;
  }
}
?>