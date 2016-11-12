<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */
//model
//author
?>
Добрый день уважаемый <?= $author->profile->name ?>

Ваша заявка № <?= $model->id ?> назначена на специалиста <?= $model->getAgentName() ?>

Вам не нужно отвечать на это сообщение.

С Уважением администрация сервиса <?= \Yii::$app->name ?>
