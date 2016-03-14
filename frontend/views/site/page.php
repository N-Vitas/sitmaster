<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
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
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE867;</i><?= $ticket->id;?></div>
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE853;</i><?= $ticket->getUserName();?></div>
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE85C;</i><?= $ticket->getStatusName();?></div>
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE84F;</i><?= $ticket->getGroupName();?></div>
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE851;</i><?= $ticket->getAgentName();?></div>
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE925;</i><?= $ticket->priorited;?></div>
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE916;</i>
			<?= \Yii::$app->formatter->asDatetime($ticket->created_at,'dd MM Y H:i:s');?></div>
			<!-- <div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE916;</i>15-01-2016 21:20:52</div>
			<div class="md-card__supporting-text"><i class="material-icons btn-sm">&#xE916;</i>15-01-2016 21:20:52</div> -->
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
				      <a class="navbar-brand" href="#"><?= $ticket->getUserName();?></a>
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
              <div class="panel panel-<?= $ticket->getStatusColor();?>">
                <div class="panel-body">
                  <h2><?= $ticket->title;?></h2>
					<p><?= $ticket->text;?></p>
					<?php if($ticket->files):?>
					<img class="img-thumbnail"  src="<?= $ticket->files;?>">
					<?php endif;?>
                </div>
              </div>
             </div>
            </div>


        	<?= ListView::widget([
              'dataProvider' => $dataProvider,
              'itemOptions' => ['class' => 'item'],
              'itemView' => 'list_comment_item',
              'layout' => "{items}\n{summary}\n{pager}",
              'pager' => [
                  'firstPageLabel' => 'Первая',
                  'lastPageLabel' => 'Последняя',
                  'nextPageLabel' => 'Следующий',
                  'prevPageLabel' => 'Предыдущий',
                  'maxButtonCount' => 10,
                  'options' => ['class'=>"pagination pagination-sm"],
              ],
            ]); ?>
            <!-- Форма -->
            <div class="form-group label-floating">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'author_id')->hiddenInput(['value'=> \Yii::$app->user->id])->label(false); ?>
            <?= $form->field($model, 'ticket_id')->hiddenInput(['value'=> $ticket->id])->label(false); ?>
			  <div class="input-group">
			    <?= $form->field($model, 'text'); ?>
			    <span class="input-group-btn">
			      <button type="submit" class="btn btn-fab btn-fab-mini">
			        <i class="material-icons">send</i>
			      </button>
			    </span>
			  </div>
			 <?php ActiveForm::end(); ?>
			</div>
            <!-- Конец формы -->
		</div>
	</div>
	</div>
</div>