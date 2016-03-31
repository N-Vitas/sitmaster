<?php

namespace frontend\components;

use yii\web\Controller as BaseController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class Controller extends BaseController
{
	public function beforeAction($action)
	{
		// Подгрузка JS файлов
		$jsFile = 'public/js/controllers/' . $this->id . '.js';
		if (is_file($jsFile)) {
			$this->view->registerJsFile($jsFile, ['depends' => '\frontend\assets\AppAsset']);
		}
		$jsFile = 'public/js/controllers/' . $this->id . '.' . $action->id . '.js';
		if (is_file($jsFile)) {
			$this->view->registerJsFile($jsFile, ['depends' => '\frontend\assets\AppAsset']);
		}

		return parent::beforeAction($action);
	}

	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','contact','about','page','logout', 'signup','create','cosed'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index','contact','about','page','logout','create','cosed'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
}
