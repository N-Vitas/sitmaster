<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use common\models\Group;

/* @var $this yii\web\View */
$this->title = 'Управление групп';
$this->params['breadcrumbs'][] = $this->title;
$upgroup = Group::find()->where(['level'=>0])->all();
$array[0] = "Новая группа";
?>
<div class="site-index">
  <div class="jumbotron">
    <h2><?= Html::encode($this->title) ?>
    <a class="btn btn-primary btn-raised" onClick="createGroup()" href="javascript:void(0)">Создать группу</a>
    </h2>
    <div class="accordion" id="accordion">
      <?php foreach ($upgroup as $value):?>
      <?php $array[$value->id] = $value->title;?>
      <div class="accordion-group">
        <div class="accordion-heading group-level-parent">
          <div class="row">
            <div class="col-md-10">
              <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?= $value->id?>">
                <?= $value->title?>
              </a>
            </div>
            <div class="col-md-2">
              <a class="pull-right" onClick="deleteGroup('<?= $value->title?>','<?= $value->id?>')" href="javascript:void(0)"><i class="material-icons">delete</i></a>
              <a class="pull-right" onClick="changeGroup('<?= $value->title?>','<?= $value->id?>')" href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
              <a class="pull-right" onClick="getUsers(<?= $value->id?>)" href="javascript:void(0)"><i class="material-icons">assignment_ind</i></a>
            </div>
          </div>
        </div>
        <div id="collapseOne<?= $value->id?>" class="accordion-body collapse in">
          <?php
            $downgrou = Group::find()->where(['level'=>$value->id])->all();
            if($downgrou){
              foreach ($downgrou as $group){?>
                <div class="group-level-children">
                  <div class="row">
                    <div class="col-md-10"><a class="accordion-toggle"><?=$group->title?></a></div>
                    <div class="col-md-2">
                      <a class="pull-right" onClick="deleteGroup('<?= $group->title?>','<?= $group->id?>')" href="javascript:void(0)"><i class="material-icons">delete</i></a>
                      <a class="pull-right" onClick="changeGroup('<?= $group->title?>','<?= $group->id?>')" href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
                      <a class="pull-right" onClick="getUsers(<?= $group->id?>)" href="javascript:void(0)"><i class="material-icons">assignment_ind</i></a>
                    </div>
                  </div>
                </div>
              <?php } 
            } 
          ?>
        </div>
      </div>
      <?php endforeach;?>
    </div>
  </div>
</div>

<?php
$data  = Html::beginForm(['site/group','', 'post', ['id' => 'create_group']]);
$data .= '<div class="form-group">';
$data .= Html::dropDownList('level', 0, $array,['class'=>'form-control']);
$data .= '</div>';
$data .= '<div class="form-group">';
$data .= '<label class="control-label" for="input">Название новой группы</label>';
$data .= Html::input('text','group','',['id'=>'input','class'=>'form-control']); 
$data .= '</div>';
$data .= '<div class="btn-group" role="group">';
$data .= Html::submitButton('Сохранить', ['class' => 'btn btn-primary','name'=>'create']);
$data .= Html::button('Отменить', ['class' => 'btn btn-primary','data-dismiss'=>'modal']);
$data .= '</div>';
$data .= Html::endForm();
Modal::begin([
    'id' => 'createGroup-modal',
    'header' => $data

]);
Modal::end(); 

Modal::begin([
    'id' => 'userGroup-modal',
    'header' => '<div id="container">Список пользователей пуст!</div>'
]);
Modal::end();

Modal::begin([
    'id' => 'changeGroup-modal',
    'header' => '<div id="groupContainer">Список группы пуст!</div>'
]);
Modal::end();

Modal::begin([
    'id' => 'deleteGroup-modal',
    'header' => '<div id="confirmContainer">
      <div class="group" id="warning">Вы действительно хотите удалить группу?</div>
      <div class="btn-group">
        <p id="error" class="text-danger"></p>
      </div>
      <hr/>
      <div class="btn-group">
        <button type="button" id="sub_delete" class="btn btn-primary">Удалить</a>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
      </div>
    </div>'
]);
Modal::end();
?>