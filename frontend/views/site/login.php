<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login jumbotron">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Заполните следующие поля для входа:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div style="color:#999;margin:1em 0">
                     Если вы забыли свой пароль Вы можете <?= Html::a('сбросить пароль', ['site/request-password-reset']) ?>.
                </div>
                <div class="form-group">
                    <?= Html::submitButton('Вход', ['class' => 'btn btn-primary btn-raised', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
