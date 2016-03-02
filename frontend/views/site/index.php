<?php
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'My Yii Application';
?>
<div class="site-index">
  <div class="jumbotron">
    <?php \yii\widgets\Pjax::begin([
      'id'=>'ticket-pjax',
    ]); ?> 
      <div class="row">
          <!-- Форма фильтра -->
          <div class="col-lg-3">
              <h2>Фильтр</h2>
              <?php $form = ActiveForm::begin(['id' => 'ticket-pjax','method' => 'get','options' => ['data-pjax' => true ]]); ?>              
              <div class="form-group">
              <p class="lead">Дата создания</p>
                      <select id="select111" class="form-control">
                        <option>Любое время</option>
                        <option>Сегодня</option>
                        <option>Вчера</option>
                        <option>Текущая неделя</option>
                        <option>За последнюю неделю</option>
                        <option>За текущий месяц</option>
                        <option>За последний месяц</option>
                      </select>
                  </div>
              <p class="lead">Статус.</p>       
                <div class="checkbox">
                  <?= $form->field($searchModel, 'status')->checkbox(['value' => 1])->label('Открыта'); ?>
                  </div>
                  <div class="checkbox">
                  <label class="checkbox-inline">
                      <input type="checkbox" id="inlineCheckbox2" value="option2"> В ожидании
                  </label>
                  </div>
                  <div class="checkbox">
                  <label class="checkbox-inline">
                      <input type="checkbox" id="inlineCheckbox3" value="option3"> Приостановлена
                  </label> 
                  </div>
                  <div class="checkbox">
                  <label class="checkbox-inline">
                      <input type="checkbox" id="inlineCheckbox3" value="option3"> Решена
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
              <!-- Пос навигация --
              <ul class="pagination pagination-sm">
                <li class="disabled"><a href="javascript:void(0)">«</a></li>
                <li class="active"><a href="javascript:void(0)">1</a></li>
                <li><a href="javascript:void(0)">2</a></li>
                <li><a href="javascript:void(0)">3</a></li>
                <li><a href="javascript:void(0)">4</a></li>
                <li><a href="javascript:void(0)">5</a></li>
                <li><a href="javascript:void(0)">»</a></li>
              </ul> <!-- Конец списка -->
          </div> <!-- Конец списка -->
      </div>
    <?php \yii\widgets\Pjax::end(); ?>
  </div>
</div>
