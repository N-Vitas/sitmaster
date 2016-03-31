<?php
use yii\helpers\Html;

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
                  <a href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
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
                  <a href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
                  <a href="javascript:void(0)"><i class="material-icons">assignment_ind</i></a>
                </div>
                <h4 class="list-group-item-heading">Имя</h4>
                <p class="list-group-item-text"><?= $profile->name ?></p>
              </div>
            </div>
            <div class="list-full-separator"></div>

            <div class="list-group-item">              
              <div class="row-content">
                <div class="least-content">
                  <a href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
                  <a href="javascript:void(0)"><i class="material-icons">assignment_ind</i></a>
                </div>
                <h4 class="list-group-item-heading">Фамилия</h4>
                <p class="list-group-item-text"><?= $profile->name ?></p>
              </div>
            </div>
            <div class="list-full-separator"></div>            

            <div class="list-group-item">              
              <div class="row-content">     
                <div class="least-content">
                  <a href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
                  <a href="javascript:void(0)"><i class="material-icons">phone</i></a>
                </div>           
                <h4 class="list-group-item-heading">Телефон</h4>
                <p class="list-group-item-text">+77078366427</p>
              </div>
            </div>
            <div class="list-full-separator"></div>

            <div class="list-group-item">              
              <div class="row-content">     
                <div class="least-content">
                  <a href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
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
                  <a href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
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
                    <a href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
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
                    <a href="javascript:void(0)"><i class="material-icons">mode_edit</i></a>
                  <?php endif;?>
                  <a href="javascript:void(0)"><i class="material-icons">assignment_ind</i></a>
                </div>
                <h4 class="list-group-item-heading">Должность</h4>
                <p class="list-group-item-text"><?= $profile->name ?></p>
              </div>
            </div>
            <div class="list-full-separator"></div>

          </div>
        </div>
      </div>
  </div>

</div>