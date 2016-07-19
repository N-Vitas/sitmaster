<?php
namespace frontend\controllers;

use Yii;
use frontend\components\Controller;
use frontend\models\SearchUser;
use common\models\User;
use common\models\Profile;
use common\models\Role;
use common\models\Group;
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

  public function actionGetAllGroup()
  {
		Yii::$app->response->format = Response::FORMAT_JSON;
		$groups = Group::find()->where(['level' => 0])->orderBy(['id' => SORT_ASC])->asArray()->all();		
		for($i = 0; $i < count($groups);$i++) {
			$groups[$i]['children'] = Group::find()->where(['level' => $groups[$i]['id']])->orderBy(['id' => SORT_ASC])->asArray()->all();
		}
    return $groups;
  }
}