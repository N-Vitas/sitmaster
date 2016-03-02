<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'Заявка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index"> 
	<div class="jumbotron">
	<div class="row">
		<!-- Детали заявки -->
		<div class="col-md-3">
			<div class="md-card__title"><h2 class="mdl-card__title-text">Детали заявки</h2></div>
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE867;</i><?= $model->id;?></div>
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE853;</i><?= $model->getUserName();?></div>
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE85C;</i><?= $model->getStatusName();?></div>
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE84F;</i>Ресторан 2</div>
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE851;</i>Максим Атрешкевич</div>
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE925;</i>Нормальный</div>
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE916;</i>15-01-2016 21:15:57</div>
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE916;</i>15-01-2016 21:20:52</div>
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE916;</i>15-01-2016 21:20:52</div>
		</div>
		<!-- Переписка -->
		<div class="col-md-9">
            <div class="row">
             <div class="col-md-12">
             	<nav class="navbar navbar-success">
				  <div class="container-fluid">
				    <div class="navbar-header">
				      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
				      <a class="navbar-brand" href="#"><?= $model->getUserName();?></a>
				    </div>

				    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				      <ul class="nav navbar-nav navbar-right">
				        <li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Действия <span class="caret"></span></a>
				          <ul class="dropdown-menu" role="menu">
					        <li><a href="#Изменить статус">Изменить статус</a></li>
					        <li><a href="#Назначить">Назначить</a></li>
					        <li><a href="#Закрыть">Закрыть</a></li>
				            <li class="divider"></li>
				            <li><a href="#">Separated link</a></li>
				            <li class="divider"></li>
				            <li><a href="#">One more separated link</a></li>
				          </ul>
				        </li>
				      </ul>				      
				    </div>
				  </div>
				</nav>
              <div class="panel panel-<?= $model->getStatusColor();?>">
                <div class="panel-body">
                  <h2><?= $model->title;?></h2>
					<p><?= $model->text;?></p>
                </div>
              </div>
             </div>
            </div>

            <div class="row">            
        	 <div class="col-md-2"></div>
        	 <div class="col-md-10">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title">Максим Атрешкевич</h3>
                </div>
                <div class="panel-body">
                  <blockquote>
				    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
				    <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
				  </blockquote>
                </div>
              </div>
             </div>
            </div>

            <div class="row">
              <div class="col-md-10">
				<div class="panel panel-success">
					<div class="panel-heading">
				  		<h3 class="panel-title">Анна ивановна</h3>
					</div>
					<div class="panel-body">
						<p>
						  <small>Material Design for Bootstrap is a Bootstrap V3 compatible theme; it is an easy way to use the new Material Design guidelines by Google in your Bootstrap 3 based application. Just include the theme, after the Bootstrap CSS and include the JavaScript at the end of your document (just before the body tag), and everything will be converted to Material Design (Paper) style.

					NOTE: This V3 compatible theme is still in development, it could be used on production websites but I can't guarantee compatibility with previous versions.</small>
						</p>
					</div>
				</div>
	          </div>
              <div class="col-md-2"></div>
            </div>

            <div class="row">
            	<div class="col-md-2"></div>
            	<div class="col-md-10">
            		<div class="panel panel-info">
		                <div class="panel-heading">
		                  <h3 class="panel-title">Максим Атрешкевич</h3>
		                </div>
		                <div class="panel-body">
						    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
						    <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
		                </div>
		            </div>
            	</div>              
            </div>
            <!-- Форма -->
            <div class="form-group label-floating">
			  <div class="input-group">
			    <label class="control-label" for="addon3a">Ответить</label>
			    <input type="text" id="addon3a" class="form-control">
			    <p class="help-block">The label is inside the <code>input-group</code> so that it is positioned properly as a placeholder.</p>
			    <span class="input-group-btn">
			      <button type="button" class="btn btn-fab btn-fab-mini">
			        <i class="material-icons">send</i>
			      </button>
			    </span>
			  </div>
			</div>
            <!-- Конец формы -->
		</div>
	</div>
	</div>
</div>