<?php
namespace frontend\controllers;

use Yii;
use frontend\components\Controller;
use common\models\User;

/**
 * Site controller
 */
class ProfileController extends Controller
{
    public function actionIndex()
    {
        if(Yii::$app->request->get("id") && Yii::$app->user->identity->role_id > 3)
            $model = User::findOne(Yii::$app->request->get("id"));
        else
            $model = User::findOne(Yii::$app->user->getId());
        // $searchModel = new TicketSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',compact('model'));
    }
}
