<?php

namespace frontend\components;

use yii\web\Controller as BaseController;

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
}
