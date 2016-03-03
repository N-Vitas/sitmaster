<div class="panel panel-<?= $model->getStatusColor();?>">
  <div class="panel-heading">
    <h3 class="panel-title"><?= $model->title; ?></h3>
  </div>
  <div class="panel-body">
    <div class="row">
      <a href="/site/page/<?= $model->id; ?>" >
        <div class="col-lg-3"><i class="material-icons btn-xs">&#xE84F;</i>Мангасуши</div>
        <div class="col-lg-3"><i class="material-icons btn-xs">&#xE925;</i><?= $model->priorited;?></div>
        <div class="col-lg-3"><i class="material-icons btn-xs">&#xE916;</i>
          <?= \Yii::$app->formatter->asDatetime($model->created_at,'dd MM Y H:i:s');?>
        </div>
        <div class="col-lg-3"><i class="material-icons btn-xs">&#xE851;</i><?= $model->getAgentName();?></div>
      </a>
    </div>
  </div>
</div>