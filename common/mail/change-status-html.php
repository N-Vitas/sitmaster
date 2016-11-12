<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
// var_dump($author->profile->name,$model->getStatusName(),\Yii::$app->name);die;
?>
<div class="password-reset">
    <h3>Добрый день уважаемый <?= Html::encode($author->profile->name) ?>.</h3><br/>
		<p>В вашей заявке № <?= $model->id ?> изменился статус на <?= Html::encode($model->getStatusName()) ?></p>
		<p>Вам не нужно отвечать на это сообщение.</p>
		<p>С Уважением администрация сервиса <?= Html::encode(\Yii::$app->name) ?></p>
</div>


