<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\web\Controller;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

use common\models\LoginForm;
use common\models\User;
use common\models\Key;
use common\models\Token;
use common\models\TokenNotification;

class LoginController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $action = $this->action->id;
        if($action=='token'){
            $behaviors['authenticator'] = [
                'class' => 'yii\filters\auth\QueryParamAuth',
                'tokenParam' => 'access_token',
            ];
        }

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'text/html' => Response::FORMAT_JSON,
                'application/json' => Response::FORMAT_JSON,
                'application/xml' => Response::FORMAT_XML,
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                // 'Access-Control-Request-Method' => ['POST', 'PUT'],
                // 'Access-Control-Request-Headers' => ['X-Wsse'],
                // 'Access-Control-Allow-Credentials' => true,
                // 'Access-Control-Max-Age' => 3600,
                // 'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            ],

        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $model = new LoginForm();
        /*$_POST['LoginForm'] = array(
            'username' => 'admin',
            'password' => 123456,
        );
         {"LoginForm":[{"username":"admin","password":"123456"}]}
        */
    	$ret = [];
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            //$token = \Yii::$app->user->identity->generateToken();
            $userModel = User::findOne($token->user_id);
        	$ret['access_token'] = $token->code;
            $ret['user_data'] = [
                'id' => \Yii::$app->user->id,
            ];
            echo json_encode($ret);
        } else {
             throw new HttpException(403, 'Неверные данные для входа');
        }
    }

    public function actionLogout()
    {
        if(\Yii::$app->user->logout())
            $ret['user_data'] = [
                'id' => \Yii::$app->user->id,
            ];
        return $ret;
    }
    public function actionCreate()
    {
        $user = Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
        ]);
        //$user->load(Yii::$app->request->post()) && $user->create()
        if($user->load(Yii::$app->request->post()) && $user->create())
            $ret['user_data'] = ['id' => $user,];
        else
            throw new HttpException(403, 'Неверные данные для создания');
        return $ret;
    }

    public function actionKey()
    {
        $ret = [];
        $apikey = \Yii::$app->request->post('activation_key');
        $device = \Yii::$app->request->post('device');
        $regkey = Key::find()->where(['activation_key'=>$apikey]);
        // if($device=='mobile'){
        //     $regkey->andWhere(['status_mobile'=>0]);
        // } else {
        //     $regkey->andWhere(['status_desktop'=>0]);
        // }
        $regkey = $regkey->one();
        $deviceList = ['mobile','pc'];
        if ($regkey && in_array($device, $deviceList)) {
            if($device=='mobile' && $regkey->status_mobile!=0){
                throw new HttpException(403, 'Ключ уже был активирован на другом устройстве');
            } elseif($device=='pc' && $regkey->status_desktop!=0) {
                throw new HttpException(403, 'Ключ уже был активирован на другом устройстве');
            }

            if(!$regkey->parent_User_id) {
                $regkey->createUser();
            }

            if ($device=='mobile') {
                $regkey->status_mobile = Key::STATUS_ACTIVATED;
                $regkey->mobile_activated_at = time();
            } else {
                $regkey->status_desktop = Key::STATUS_ACTIVATED;
                $regkey->desktop_activated_at = time();
            }

            if(!$regkey->expired_at) {
                $regkey->expired_at = strtotime(Key::EXPIRATION_TIME);
            }

            $regkey->save();

            $ret['message'] = '';
            $ret['status'] = 'ok';

            return $ret;
        } else {
            throw new NotFoundHttpException('Ключ не найден в системе');
        }
    }

    public function actionToken()
    {
        $ret = [];
        $token = $this->checkAccess();

        $userModel = User::findOne($token->user_id);
        $ret['expire'] = $token->getExpirationDate();
        $ret['expire_string'] = date('d-m-Y H:i',$ret['expire']);
        $ret['user_data'] = [
            'id' => $userModel->id,
        ];
        echo json_encode($ret);

    }

    public function checkAccess()
    {
        $token = User::getToken(\Yii::$app->request->getQueryParam('access_token'));
        if($token){
            return $token;
        } else {
            throw new \Exception("Error Processing Request");
        }
    }
}
?>