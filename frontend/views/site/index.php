<?php
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Заявки';
?>
<div class="site-index">
  <div class="jumbotron">
    <?php Pjax::begin([
      'id'=>'ticket-pjax',
    ]); ?> 
      <div class="row">
          <!-- Форма фильтра -->
          <div class="col-lg-3">
              <h2>Фильтр</h2>        
              <?php $form = ActiveForm::begin([
                  'action' => ['index'],
                  'method' => 'get',
              ]); ?>
              <div class="form-group">
              <p class="lead">Дата создания</p>
                      <select name="TicketSearch[created_at]" id="select111" class="form-control">
                        <option value="all_time"<?= $searchModel->created_at == 'all_time' ? 'selected':'';?>>Любое время</option>
                        <option value="today_time"<?= $searchModel->created_at == 'today_time' ? 'selected':'';?>>Сегодня</option>
                        <option value="yesterday"<?= $searchModel->created_at == 'yesterday' ? 'selected':'';?>>Вчера</option>
                        <option value="this_week"<?= $searchModel->created_at == 'this_week' ? 'selected':'';?>>Текущая неделя</option>
                        <option value="last_week"<?= $searchModel->created_at == 'last_week' ? 'selected':'';?>>За последнюю неделю</option>
                        <option value="this_month"<?= $searchModel->created_at == 'this_month' ? 'selected':'';?>>За текущий месяц</option>
                        <option value="last_month"<?= $searchModel->created_at == 'last_month' ? 'selected':'';?>>За последний месяц</option>
                      </select>
                  </div>
              <p class="lead">Статус.</p>       
                <div class="checkbox">
                  <label class="checkbox-inline">
                    <input type="checkbox" name="TicketSearch[status][]" id="inlineCheckbox2" value="1" <?=in_array(1, (array)$searchModel->status)?'checked':''?>/> Открыта
                  </label>
                  </div>
                  <div class="checkbox">
                  <label class="checkbox-inline">
                      <input type="checkbox" name="TicketSearch[status][]" id="inlineCheckbox2" value="2" <?=in_array(2, (array)$searchModel->status)?'checked':''?>/> В ожидании
                  </label>
                  </div>
                  <div class="checkbox">
                  <label class="checkbox-inline">
                      <input type="checkbox" name="TicketSearch[status][]" id="inlineCheckbox3" value="3" <?=in_array(3, (array)$searchModel->status)?'checked':''?>/> Приостановлена
                  </label> 
                  </div>
                  <div class="checkbox">
                  <label class="checkbox-inline">
                      <input type="checkbox" name="TicketSearch[status][]" id="inlineCheckbox3" value="4" <?=in_array(4, (array)$searchModel->status)?'checked':''?>/> Решена
                  </label> 
                  </div>

              <p class="lead">Группа.</p>     
                <div class="checkbox">
                  <label class="checkbox-inline">
                      <input type="checkbox" id="inlineCheckbox1" value="option1"> Ресторан
                  </label>
                  </div>
                  <div class="checkbox">
                  <label class="checkbox-inline">
                      <input type="checkbox" id="inlineCheckbox2" value="option2"> Кафе
                  </label>
                  </div>

              <p class="lead">Приоритет.</p>     
                <div class="checkbox">
                  <label class="checkbox-inline">
                      <input type="checkbox" id="inlineCheckbox1" value="option1"> Нормальный
                  </label>
                  </div>
                  <div class="checkbox">
                  <label class="checkbox-inline">
                      <input type="checkbox" id="inlineCheckbox2" value="option2"> Срочный
                  </label>
                  </div>

              <div class="form-group">
                  <?= Html::submitButton('Применить', ['class' => 'btn btn-primary btn-raised']) ?>
              </div>

              <?php ActiveForm::end(); ?>
          </div> <!-- Конец формы -->
          <!-- Список завок -->
          <div class="col-lg-9">
              <h2>Список завок</h2>
              <div class="bs-component">
                <?= ListView::widget([
                  'dataProvider' => $dataProvider,
                  'itemOptions' => ['class' => 'item'],
                  'itemView' => 'list_item',
                  // 'itemView' => function ($model, $key, $index, $widget) {
                  //   return $this->render('list_item', ['model' => $model]);
                  // },
                  'layout' => "{items}\n{summary}\n{pager}",
                  'options' => [
                    'id' => 'listview'
                  ],
                  'pager' => [
                      'firstPageLabel' => 'Первая',
                      'lastPageLabel' => 'Последняя',
                      'nextPageLabel' => 'Следующий',
                      'prevPageLabel' => 'Предыдущий',
                      'maxButtonCount' => 10,
                      'options' => ['class'=>"pagination pagination-sm"],
                  ],
                ]); ?>
              </div>
          </div> <!-- Конец списка -->
      </div>
    <?php Pjax::end(); ?>
  </div>
</div>
