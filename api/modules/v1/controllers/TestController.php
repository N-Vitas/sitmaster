<?php

namespace api\modules\v1\controllers;

use Yii;
use api\components\Controller;
use yii\web\HttpException;

class TestController extends Controller
{
  public function actionIndex()
  {
    $item = ['title'=>'API Для работы с приложениями'.$id,'author'=>'Никонов Виталий'];
    return $item;
  } 

  public function actionLogin()
  {
    $item = ['title'=>Yii::$app->request->post('title'),'author'=>'Никонов Виталий'];
    return $item;
  }
}
?>