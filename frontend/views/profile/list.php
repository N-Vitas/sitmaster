<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Список пользователей');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jumbotron">

    <h1><?= Html::encode($this->title) ?>
    <?= Html::a('Новый пользователь', ['create'], ['class' => 'btn btn-primary btn-raised']) ?>
    </h1>

	<?php echo $this->render('flash') ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            'email',
            [
                'attribute' => 'created_at',
                'format' =>  ['date', 'dd-MM-yy hh:mm:ss'],
            ],

            [
              'class' => 'yii\grid\ActionColumn',
              'header'=>'Действия', 
              'headerOptions' => ['width' => '80'],
              'template' => '{update} {delete}',
              'buttons' => [
                'update' => function ($url,$model) {
                    return Html::a(
                    '<i class="material-icons">mode_edit</i>', 
                    $url);
                },
                'delete' => function ($url,$model,$key) {
                    return Html::a('<i class="material-icons">delete</i>', $url,[
                    'title'=>'Удалить', 'aria-label'=>'Удалить', 'data-confirm'=>'Вы ,уверены, что хотите удалить этот элемент?',
                    'data-method'=>'post', 'data-pjax'=>'0'
                    ]);
                },
              ],
            ],
        ],
        'tableOptions' => [
            'class' => 'table table-striped table-condensed table-bordered'
        ],
    ]); ?>
    <?php Modal::begin([
        'id' => 'delete-modal',
        'header' => '<h1>Вы действительно хотите удалить пользователя</h1>'

    ]); ?>
    <?php Modal::end(); ?>

</div>