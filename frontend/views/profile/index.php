<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use common\models\Role;

/* @var $this yii\web\View */
$this->title = 'Мой профиль';
$this->params['breadcrumbs'][] = $this->title;
$profile = $model->profile;
?>
<div class="profile-index">
  <div class="jumbotron">    
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <h2><?= Html::encode($this->title) ?></h2>
          <div class="list-group">

            <div class="list-group-item">            
              <div class="row-content">
                <div class="least-content">
                  <a class="activity-view-link" onClick="editProfile('user','username','<?= $model->username?>')" href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
                  <a href="javascript:void(0)"><i class="material-icons">assignment_ind</i></a>
                </div>
                <h4 class="list-group-item-heading">Логин</h4>
                <p class="list-group-item-text"><?= $model->username?></p>
              </div>
            </div>
            <div class="list-full-separator"></div>

            <div class="list-group-item">              
              <div class="row-content">
                <div class="least-content">
                  <a class="activity-view-link" onClick="editProfile('profile','name','<?= $profile->name?>')" href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
                  <a href="javascript:void(0)"><i class="material-icons">assignment_ind</i></a>
                </div>
                <h4 class="list-group-item-heading">Имя Фамилия</h4>
                <p class="list-group-item-text"><?= $profile->name ?></p>
              </div>
            </div>
            <div class="list-full-separator"></div>          

            <div class="list-group-item">              
              <div class="row-content">     
                <div class="least-content">
                  <a class="activity-view-link" onClick="editProfile('profile','phone','<?= $profile->phone?>')" href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
                  <a href="javascript:void(0)"><i class="material-icons">phone</i></a>
                </div>           
                <h4 class="list-group-item-heading">Телефон</h4>
                <p class="list-group-item-text"><?= $profile->phone?></p>
              </div>
            </div>
            <div class="list-full-separator"></div>

            <div class="list-group-item">              
              <div class="row-content">     
                <div class="least-content">
                  <a class="activity-view-link" onClick="editProfile('user','email','<?= $model->email?>')" href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
                  <a href="javascript:void(0)"><i class="material-icons">email</i></a>
                </div>           
                <h4 class="list-group-item-heading">Почта</h4>
                <p class="list-group-item-text"><?= $model->email ?></p>
              </div>
            </div>
            <div class="list-full-separator"></div>

            <div class="list-group-item">              
              <div class="row-content">
                <div class="least-content">
                  <a class="activity-view-link" onClick="editProfile('profile','location','<?= $profile->location?>')"  href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
                  <a href="javascript:void(0)"><i class="material-icons">home</i></a>
                </div>
                <h4 class="list-group-item-heading">Адресс</h4>
                <p class="list-group-item-text"><?= $profile->location ?></p>
              </div>
            </div>
            <div class="list-full-separator"></div>

            <div class="list-group-item">              
              <div class="row-content">
                <div class="least-content">
                  <?php if(Yii::$app->user->identity->role_id > 3):?>                   
                    <a class="activity-view-link" href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
                  <?php endif;?>
                  <a href="javascript:void(0)"><i class="material-icons">business</i></a>
                </div>
                <h4 class="list-group-item-heading">Место работы</h4>
                <?php foreach ($model->getGroups() as $group):?> 
                  <p class="list-group-item-text"><?= $group->title ?></p>
                <?php endforeach;?>
              </div>
            </div>
            <div class="list-full-separator"></div>

            <div class="list-group-item">              
              <div class="row-content">
                <div class="least-content">
                  <?php if(Yii::$app->user->identity->role_id > 3):?>                   
                    <a class="activity-view-link" onClick="editRole()" href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
                  <?php endif;?>
                  <a href="javascript:void(0)"><i class="material-icons">assignment_ind</i></a>
                </div>
                <h4 class="list-group-item-heading">Должность</h4>
                <p class="list-group-item-text"><?= $model->getRoleName()?></p>
              </div>
            </div>
            <div class="list-full-separator"></div>

          </div>
        </div>
      </div>
  </div>
  <?php
      $data  = Html::beginForm(['profile/index', 'id' => $profile->user_id], 'post', ['id' => 'change_profile']);
      $data .= '<div class="form-group">';
      $data .= Html::input('text','profile','',['id'=>'input','class'=>'form-control']); 
      $data .= '</div>';
      $data .= '<div class="btn-group" role="group">';
      $data .= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']);
      $data .= Html::button('Отменить', ['class' => 'btn btn-primary','data-dismiss'=>'modal']);
      $data .= '</div>';
      $data .= Html::endForm();
    ?>
    <?php Modal::begin([
        'id' => 'activity-modal',
        'header' => $data

    ]); ?>
    <?php Modal::end(); ?>

  <?php
      $roles = Role::find()->all();
      foreach ($roles as $value) {
        $array[$value->id] = $value->title;
      }
      $data  = Html::beginForm(['profile/index', 'id' => $profile->user_id], 'post', ['id' => 'change_role']);
      $data .= '<div class="form-group">';
      $data .= Html::dropDownList('role', $model->role_id, $array,['class'=>'form-control']);
      $data .= '</div>';
      $data .= '<div class="btn-group" role="group">';
      $data .= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']);
      $data .= Html::button('Отменить', ['class' => 'btn btn-primary','data-dismiss'=>'modal']);
      $data .= '</div>';
      $data .= Html::endForm();
    ?>
    <?php Modal::begin([
        'id' => 'role-activity-modal',
        'header' => $data

    ]); ?>
    <?php Modal::end(); ?>
</div>