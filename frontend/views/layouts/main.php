<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\rbac\Role;

$this->beginContent('@frontend/views/layouts/structure.php') ?>
<div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Sitmaster.kz',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar navbar-inverse',///*-fixed-top*/
                ],
            ]);
            $menuItems = [
                ['label' => 'Главная', 'url' => ['/site/index']],
                ['label' => 'Создать заявку', 'url' => ['/site/create']],
                ['label' => 'Профиль', 'url' => ['/profile']],
                ['label' => 'Обратная связь', 'url' => ['/site/contact']],
            ];
            if(Yii::$app->user->identity->role_id > 2){
                $menuItems[] = ['label' => 'Статистика', 'url' => ['/site/about']];
            }
            if(Yii::$app->user->identity->role_id > 3){
                $menuItems[] = ['label' => 'Группы', 'url' => ['/site/group']];
            }            
            if (Yii::$app->user->isGuest) {
                // $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => 'Выход (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>
        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
</div>
<?php $this->endContent(); ?>