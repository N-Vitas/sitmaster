<?php

namespace api\modules\v1\controllers;

use Yii;
use common\models\LoginForm;
use api\components\Controller;


class AuthController extends Controller
{
  public function actionLogin()
  {
    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
        return $model->getUser();
    } else {
        throw new \yii\base\Exception( "Неверные данные авторизации.",401);
    }
  }
}
?>