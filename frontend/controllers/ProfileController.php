<?php
namespace frontend\controllers;

use Yii;
use frontend\components\Controller;
use common\models\User;
use common\models\Profile;
use common\models\Role;

/**
 * Site controller
 */
class ProfileController extends Controller
{
    public function actionIndex()
    {        
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
        else{
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
        // $searchModel = new TicketSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',compact('model'));
    }
}
