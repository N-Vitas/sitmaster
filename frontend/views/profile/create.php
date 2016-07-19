<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Group;
use common\models\Role;


$this->title = Yii::t('app', 'Новый пользователь');
$this->params['breadcrumbs'][] = ['label' => 'Пользователь', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo $this->render('flash') ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Html::encode($this->title) ?>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => 255, 'autofocus' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'location')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'role_id')->dropDownList(ArrayHelper::map(Role::find()->all(), 'id', 'title'),['id'=>'role'])?>
        <div id="group">    
        <?= $form->field($model, 'group')->dropDownList(ArrayHelper::map(Group::find()->where(['!=','level',0])->all(), 'id', 'title'))?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-raised']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>