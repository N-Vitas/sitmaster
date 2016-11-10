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
class ApiController extends Controller
{
	public $layout = 'api';

  public function actionIndex()
  {
		Yii::$app->response->format = Response::FORMAT_XML;
    $item = ['sdfsdf'=>'sdf','sfffffs'=>'fssssssdf'];
    return $item;
  }

  public function actionGetUsersGroup()
  {
		Yii::$app->response->format = Response::FORMAT_JSON;
    return Group::find()->where(['!=','level',0])->asArray()->all();
  }

  public function actionGetUserlistGroup($id)
  {
    Yii::$app->response->format = Response::FORMAT_JSON;
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
		Yii::$app->response->format = Response::FORMAT_JSON;
		$groups = Group::find()->where(['level' => 0])->orderBy(['id' => SORT_ASC])->asArray()->all();		
		for($i = 0; $i < count($groups);$i++) {
			$groups[$i]['children'] = Group::find()->where(['level' => $groups[$i]['id']])->orderBy(['id' => SORT_ASC])->asArray()->all();
		}
    return $groups;
  }

  public function actionChangeGroup($id){
    Yii::$app->response->format = Response::FORMAT_JSON;
    if(Yii::$app->request->post('title')){
      $group = Group::find()->where(['id'=>$id])->one();
      $group->title = Yii::$app->request->post('title');
      if($group->save())
        return ['result'=>true];
      else
        return ['result'=>false];
    }
    return ['result'=>false];
  }

  public function actionDeleteGroup($id){
    Yii::$app->response->format = Response::FORMAT_JSON;
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