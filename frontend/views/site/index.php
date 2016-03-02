<?php
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="jumbotron">        
        <div class="row">
            <!-- Форма фильтра -->
            <div class="col-lg-3">
                <h2>Фильтр</h2>
               <form> 
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
                    <label class="checkbox-inline">
                        <input type="checkbox" id="inlineCheckbox1" value="option1"> Открыта
                    </label>
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

                    
                  <button type="submit" class="btn btn-primary btn-raised">Применить</button>
                </form> 
            </div> <!-- Конец формы -->
            <!-- Список завок -->
            <div class="col-lg-9">
                <h2>Список завок</h2>
                <div class="bs-component">
                  <?php foreach ($models as $model): ?>
                  <div class="panel panel-<?= $model->getStatusColor();?>">
                    <div class="panel-heading">
                      <h3 class="panel-title"><?= $model->title; ?></h3>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <a href="/site/page/<?= $model->id; ?>" >
                          <div class="col-lg-3"><i class="material-icons btn-xs">&#xE84F;</i>Мангасуши</div>
                          <div class="col-lg-3"><i class="material-icons btn-xs">&#xE925;</i>Нормальный</div>
                          <div class="col-lg-3"><i class="material-icons btn-xs">&#xE916;</i>26 июня 2016</div>
                          <div class="col-lg-3"><i class="material-icons btn-xs">&#xE851;</i>Максим Атрешкевич</div>
                        </a>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; ?>

                  <!-- Далее демо для цветовой гаммы статуса -->
                  <div class="panel panel-success">
                    <div class="panel-heading">
                      <h3 class="panel-title">Сломалась мышь</h3>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <a href="/site/create" >
                          <div class="col-lg-3"><i class="material-icons btn-xs">&#xE84F;</i>Мангасуши</div>
                          <div class="col-lg-3"><i class="material-icons btn-xs">&#xE925;</i>Нормальный</div>
                          <div class="col-lg-3"><i class="material-icons btn-xs">&#xE916;</i>26 июня 2016</div>
                          <div class="col-lg-3"><i class="material-icons btn-xs">&#xE851;</i>Максим Атрешкевич</div>
                        </a>
                      </div>
                    </div>
                  </div>

                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      <h3 class="panel-title">В ожидании</h3>
                    </div>
                    <div class="panel-body">
                      Panel content
                    </div>
                  </div>

                  <div class="panel panel-danger">
                    <div class="panel-heading">
                      <h3 class="panel-title">Приостановленная</h3>
                    </div>
                    <div class="panel-body">
                      Panel content
                    </div>
                  </div>

                  <div class="panel panel-info">
                    <div class="panel-heading">
                      <h3 class="panel-title">Решена</h3>
                    </div>
                    <div class="panel-body">
                      Panel content
                    </div>
                  </div>
                </div>
                <!-- Пос навигация -->
                <ul class="pagination pagination-sm">
                  <li class="disabled"><a href="javascript:void(0)">«</a></li>
                  <li class="active"><a href="javascript:void(0)">1</a></li>
                  <li><a href="javascript:void(0)">2</a></li>
                  <li><a href="javascript:void(0)">3</a></li>
                  <li><a href="javascript:void(0)">4</a></li>
                  <li><a href="javascript:void(0)">5</a></li>
                  <li><a href="javascript:void(0)">»</a></li>
                </ul>
            </div> <!-- Конец списка -->
        </div>
    </div>
</div>
