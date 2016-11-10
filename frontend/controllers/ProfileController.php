<?php
namespace frontend\controllers;

use Yii;
use frontend\components\Controller;
use frontend\models\SearchUser;
use common\models\User;
use common\models\Profile;
use common\models\Role;
use common\models\UserGroup;
use yii\web\Response;

/**
 * Site controller
 */
class ProfileController extends Controller
{
  public function actionIndex()
  {    
    if(!Yii::$app->request->get("id") && Yii::$app->user->identity->role_id > 3){
      $searchModel = new SearchUser();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      return $this->render('list', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
      ]);
    }else{
      $model = User::findOne(Yii::$app->user->getId());
    }
    //Если есть id и роль админ 
    if(Yii::$app->request->get("id") && Yii::$app->user->identity->role_id > 3){
      if(Yii::$app->request->post("phone") && Yii::$app->request->get("id")){
      $profile = Profile::find()->where(['user_id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->phone = Yii::$app->request->post("phone");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("name") && Yii::$app->request->get("id")){
        $profile = Profile::find()->where(['user_id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->name = Yii::$app->request->post("name");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("location") && Yii::$app->request->get("id")){
        $profile = Profile::find()->where(['user_id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->location = Yii::$app->request->post("location");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("username") && Yii::$app->request->get("id")){
        $profile = User::find()->where(['id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->username = Yii::$app->request->post("username");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("email") && Yii::$app->request->get("id")){
        $profile = User::find()->where(['id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->email = Yii::$app->request->post("email");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("role") && Yii::$app->request->get("id")){
        $profile = User::find()->where(['id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->role_id = Yii::$app->request->post("role");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("group") && Yii::$app->request->get("id")){
        UserGroup::deleteAll(['user_id'=>Yii::$app->request->get("id")]);
        if(is_array(Yii::$app->request->post("group"))){
          foreach (Yii::$app->request->post("group") as $key => $group_id) {
            $group = new UserGroup();
            $group->user_id = Yii::$app->request->get("id"); 
            $group->group_id = $group_id;
            $group->save();
          }
        }else{
          $group = new UserGroup();
          $group->user_id = Yii::$app->request->get("id"); 
          $group->group_id = Yii::$app->request->post("group");
          $group->save();  
        }  
      }
      $model = User::findOne(Yii::$app->request->get("id"));
    }
    if(Yii::$app->request->get("id") && Yii::$app->user->identity->role_id < 3){
      if(Yii::$app->request->post("phone") && Yii::$app->request->get("id") == Yii::$app->user->getId()){
        $profile = Profile::find()->where(['user_id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->phone = Yii::$app->request->post("phone");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("name") && Yii::$app->request->get("id") == Yii::$app->user->getId()){
        $profile = Profile::find()->where(['user_id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->name = Yii::$app->request->post("name");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("location") && Yii::$app->request->get("id") == Yii::$app->user->getId()){
        $profile = Profile::find()->where(['user_id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->location = Yii::$app->request->post("location");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("username") && Yii::$app->request->get("id") == Yii::$app->user->getId()){
        $profile = User::find()->where(['id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->username = Yii::$app->request->post("username");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("email") && Yii::$app->request->get("id") == Yii::$app->user->getId()){
        $profile = User::find()->where(['id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->email = Yii::$app->request->post("email");
          $profile->save();
        }
      }
      $model = User::findOne(Yii::$app->user->getId());
    }
    return $this->render('index',compact('model'));          
  }

  public function actionCreate()
    {      
      $model = new \frontend\models\SignupForm();
      if ($model->load(Yii::$app->request->post())) {
        if ($user = $model->signup()) {
          return $this->redirect('/profile');
        }
      }

      return $this->render('create', [
        'model' => $model,
      ]);
    }

  public function actionDelete($id){
    $user = User::findOne($id);
    $user->flags = 1;
    if($user->save()){
      return $this->redirect('/profile');
    }
  }

  public function actionUpdate($id)
  {
    //Если есть id и роль админ 
    if(Yii::$app->request->get("id") && Yii::$app->user->identity->role_id > 3){
      if(Yii::$app->request->post("phone") && Yii::$app->request->get("id")){
      $profile = Profile::find()->where(['user_id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->phone = Yii::$app->request->post("phone");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("name") && Yii::$app->request->get("id")){
        $profile = Profile::find()->where(['user_id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->name = Yii::$app->request->post("name");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("location") && Yii::$app->request->get("id")){
        $profile = Profile::find()->where(['user_id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->location = Yii::$app->request->post("location");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("username") && Yii::$app->request->get("id")){
        $profile = User::find()->where(['id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->username = Yii::$app->request->post("username");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("email") && Yii::$app->request->get("id")){
        $profile = User::find()->where(['id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->email = Yii::$app->request->post("email");
          $profile->save();
        }
      }
      if(Yii::$app->request->post("role") && Yii::$app->request->get("id")){
        $profile = User::find()->where(['id'=>Yii::$app->request->get("id")])->one();
        if($profile){
          $profile->role_id = Yii::$app->request->post("role");
          $profile->save();
        }
      }
      $model = User::findOne(Yii::$app->request->get("id"));
    }
    return $this->render('index',compact('model'));  
  }

  protected function findModel($id)
  {
    $user = User::findOne($id);
    if ($user === null) {
        throw new NotFoundHttpException('The requested page does not exist');
    }
    return $user;
  }

}
