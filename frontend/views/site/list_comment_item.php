<?php if($model->author_id == \Yii::$app->user->id):?>
<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-10">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title"><?= $model->getAuthorName();?></h3>
      </div>
      <div class="panel-body">
          <p><?= $model->text;?></p>
      </div>
    </div>
  </div>
</div>
<?php else:?>
<div class="row">
  <div class="col-md-10">
    <div class="panel panel-success">
      <div class="panel-heading">
          <h3 class="panel-title"><?= $model->getAuthorName();?></h3>
      </div>
      <div class="panel-body">
        <p><?= $model->text;?></p>
      </div>
    </div>
  </div>
  <div class="col-md-2"></div>
</div>
<?php endif;?>