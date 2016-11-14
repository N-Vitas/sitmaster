<?php

namespace api\components;

use Yii;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class Controller extends \yii\rest\Controller
{
  public function behaviors()
  {
    $behaviors = parent::behaviors();
    $behaviors['authenticator'] = [
      'class' => 'api\components\HttpHeaderAuth',
      'except' => ['login'],
    ];
    $behaviors['corsFilter'] = [
      'class' => \yii\filters\Cors::className(),
      'cors' => [
        'Origin' => ['*'],
      ],

    ];
    $behaviors['bootstrap'] = [
      'class' => ContentNegotiator::className(),
      'formats' => [
        'application/json' => Response::FORMAT_JSON,
      ]
    ];
    return $behaviors;
  }
}
?>