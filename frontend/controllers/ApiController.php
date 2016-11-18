<?php
namespace frontend\controllers;

use Yii;
use frontend\components\Controller;
use frontend\models\SearchUser;
use common\models\User;
use common\models\Profile;
use common\models\Role;
use common\models\Group;
use common\models\Ticket;
use common\models\UserGroup;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * Site controller
 */
class ApiController extends \yii\web\Controller
{
	public $layout = 'api';

  //  public function beforeAction($action) {
  //     $this->enableCsrfValidation = ($action->id !== "login"); 
  //     return parent::beforeAction($action);
  // }

  public function behaviors()
  {
      $behaviors = parent::behaviors();
      // $behaviors['authenticator'] = [
      //     'class' => 'frontend\components\HttpHeaderAuth',
      //     'except' => ['index'],
      // ];
      $behaviors['corsFilter'] = [
          'class' => \yii\filters\Cors::className(),
          'cors' => [
              'Origin' => ['*'],
          ],

      ];
      return $behaviors;
  }

  public function actions()
  {
      return [
        'error' => [
          'class' => 'yii\web\ErrorAction',
        ]
      ];
  }

  public function init(){
    Yii::$app->response->format = Response::FORMAT_JSON; 
  }

  public function actionIndex()
  {
    $item = ['title'=>'API Для работы с приложениями','author'=>'Никонов Виталий'];
    return $item;
  }

  public function actionLogin()
  {
    $item = ['title'=>Yii::$app->request->post('title'),'author'=>'Никонов Виталий'];
    return $item;
  }

  public function actionGetUsersGroup()
  {
    return Group::find()->where(['!=','level',0])->asArray()->all();
  }

  public function actionGetUserlistGroup($id)
  {
    $list = UserGroup::find()->where(['group_id'=>$id])->orderBy(['user_id' => SORT_ASC])->asArray()->all();
    if(count($list)){
      for($i=0;$i<count($list);$i++) {
        $user = User::find()->where(['id'=>$list[$i]['user_id']])->one();
        $list[$i]['username'] = $user->username;
        $list[$i]['rolename'] = $user->getRoleName();
      }
      return $list;
    }else{
      return [];
    }
  }

  public function actionGetAllGroup()
  {
		$groups = Group::find()->where(['level' => 0])->orderBy(['id' => SORT_ASC])->asArray()->all();		
		for($i = 0; $i < count($groups);$i++) {
			$groups[$i]['children'] = Group::find()->where(['level' => $groups[$i]['id']])->orderBy(['id' => SORT_ASC])->asArray()->all();
		}
    return $groups;
  }

  public function actionChangeGroup($id){
    if(Yii::$app->request->post('title')){
      $group = Group::find()->where(['id'=>$id])->one();
      $group->title = Yii::$app->request->post('title');
      if($group->save())
        return ['result'=>true];
      else
        return ['result'=>false];
    }
    return ['result'=>false,'error'=>'Not params title'];
  }

  public function actionDeleteGroup($id){
    if(Group::find()->where(['level'=>$id])->count() > 0){
      return ['result'=>false];
    }else{
      if(Group::deleteAll(['id'=>$id])){
        UserGroup::deleteAll(['group_id'=>$id]);
        Ticket::deleteAll(['cat_id'=>$id]);
        return ['result'=>true];
      }
      return ['result'=>false,'error'=>true];
    }
  }
}