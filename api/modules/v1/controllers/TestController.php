<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\helpers\ArrayHelper;
use common\models\TestModel;
use common\models\User;
use common\models\Users;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;

class TestController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // $behaviors['authenticator'] = [
        //     'class' => 'api\components\HttpHeaderAuth',
        // ];
        // $behaviors['corsFilter'] = [
        //     'class' => \yii\filters\Cors::className(),
        //     'cors' => [
        //         'Origin' => ['*'],
        //     ],

        // ];
        return $behaviors;
    }

    public function actionIndex($key=0,$id=0)
    {
        $ret['id'] = $id;
        $ret['key'] = $key;
        $ret['post'] = \Yii::$app->request->post();
        $ret['name'] = "index";
        if(\Yii::$app->request->post("access_token") == "FB0kue1c8i810kkgv551E2PDzxX8L81Y")
            $id=1;
        if($id)
        return $ret;
        else
        throw new HttpException(403, 'The requested Item could not be found.');
        
        //return json_encode($ret);  
    }   
}
?>