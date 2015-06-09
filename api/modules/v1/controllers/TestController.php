<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use common\models\TestModel;
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
        return $ret;
        //return json_encode($ret);  
    }
    public function actionTest($key=0)
    {
        $ret['name'] = "test";
        $ret['key'] = $key;
        if(\Yii::$app->request->post())
            //throw new HttpException(403, 'Присутствуют POST данные - '.var_dump(\Yii::$app->request->post('LoginForm')));
        $ret['post'] = \Yii::$app->request->post();
        return $ret;
    }

    public function actionCreate()
    {
            $params = $_POST;

            $model = new TestModel();
            $model->attributes = $params;

            if($model->save()) {
                $ret['status'] = 'ok';
                $ret['model'] = $model->attributes;
            } else {
                $ret['errors'] = $model->getErrors();
            }
            return $ret;
    }

}
?>