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
        <?php if($model->role_id > 2):?> 
          <?php
            $f_group = Group::find()->where(['level' => 0])->all();
            // var_dump($f_group);die;
          ?>
          <label class="control-label" for="group">Место работы</label>
          <div class="lead-group">
            <?php $count = 0; $checked = false;?>
            <?php foreach($f_group as $item):?>
              <?php if(isset($model->group[$count])):?>
                <?php 
                  if($model->group[$count] == $item->id){
                    $checked = "checked";
                    $count++;
                  }else{
                    $checked = "";
                  }
                ?>
              <?php else:?> 
              <?php $checked = "";?> 
              <?php endif;?>
            <div class="checkbox btn-checkbox">
              <label class="checkbox-inline">
                <input class="agree" type="checkbox" <?= $checked?> name="SignupForm[group][]" value="<?= $item->id;?>">
                <span class="checkbox-material"><span class="check"></span></span>&nbsp;<?= $item->title;?>
              </label>

              <?php $l_group = Group::find()->where(['level' => $item->id])->all();?>
              <?php if(count($l_group) > 0):?>
                <?php foreach($l_group as $litem):?>
                  <?php if(isset($model->group[$count])):?>
                    <?php 
                      if($model->group[$count] == $litem->id){
                        $checked = "checked";
                        $count++;
                      }else{
                        $checked = "";
                      }
                    ?>
                  <?php else:?> 
                  <?php $checked = "";?> 
                  <?php endif;?>
                  <div class="checkbox checkbox-group children<?= $litem->id;?>">
                    <label class="checkbox-inline">
                      <input type="checkbox" <?= $checked?> name="SignupForm[group][]" value="<?= $litem->id;?>">
                      <span class="checkbox-material"><span class="check"></span></span>&nbsp;<?= $litem->title;?>
                    </label>
                  </div>
                <?php endforeach;?>
              <?php endif;?>
            </div>
            <?php endforeach;?>
          </div>

        <?php else:?>            
          <?= $form->field($model, 'group')->dropDownList(ArrayHelper::map(Group::find()->where(['!=','level',0])->all(), 'id', 'title'))?>
        <?php endif;?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-raised']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>