<?php

namespace api\modules\v1\controllers;

use Yii;
use common\models\Profile;
use api\components\Controller;
use yii\data\ActiveDataProvider;


class ProfileController extends Controller
{
  public function actionIndex()
  {
    return Profile::findOne(\Yii::$app->user->id);
  }
  
}
?>