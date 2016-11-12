<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */
//model
//author
?>
Добрый день уважаемый <?= $author->profile->name ?>

В вашей заявке № <?= $model->id ?> изменился статус на <?= $model->getStatusName() ?>

Вам не нужно отвечать на это сообщение.

С Уважением администрация сервиса <?= \Yii::$app->name ?>
