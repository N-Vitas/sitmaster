<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Статистика';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
  <div class="jumbotron">
    <h2><?= Html::encode($this->title) ?></h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Ресторан</th>
          <th>Открытых</th>
          <th>В работе</th>
          <th>Приостановленных</th>
          <th>Решенных</th>
          <th>Итого</th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i=0; $i < count($statistic); $i++) { ?>
        <tr>
          <th scope="row"><?= $statistic[$i]['title']?></th>
          <td class="success"><?= $statistic[$i]['open']?></td>
          <td class="primary"><?= $statistic[$i]['wait']?></td>
          <td class="danger"><?= $statistic[$i]['stop']?></td>
          <td class="info"><?= $statistic[$i]['close']?></td>
          <td><?= $statistic[$i]['total']?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
