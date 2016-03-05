<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \common\models\Group;
// use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Создание заявки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-create">
<div class="jumbotron"> 
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'contact-form','options' => ['enctype' => 'multipart/form-data']]); ?>
                <?= $form->field($model, 'title'); ?>
                <?= $form->field($model, 'priorited')->listBox(['Нормальный'=>'Нормальный','Срочный'=>'Срочный'],['size'=>1]);?>
                <?php
                    $group = \Yii::$app->user->identity->getGroups();
                    if($group){
                        foreach($group AS $top){
                            if($top->level){
                                $category[$top->id] = $top->title;
                            }
                            else{
                                $category[$top->id] = $top->title;
                                $items = Group::find()->where(['level'=>$top->id])->all();
                                foreach($items AS $item){
                                    $category[$item->id] = $item->title;
                                }
                            }
                        }
                    }
                    if(count($category) > 1){
                        echo $form->field($model, 'cat_id')->listBox($category,['size'=>1]);
                    }
                    else{
                        echo $form->field($model, 'cat_id')->hiddenInput(['value'=> $category[0]])->label(false);
                    }
                ?>                
                <?= $form->field($model, 'text')->textArea(['rows' => 6]); ?>
                <?= $form->field($model, 'user_id')->hiddenInput(['value'=> \Yii::$app->user->id])->label(false); ?>
                <?= $form->field($model, 'status')->hiddenInput(['value'=> 1])->label(false); ?>
                <?php /* $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-2">{image}</div><div class="col-lg-10 btn-raised">{input}</div></div>',
                ]) */?>
                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-raised', 'name' => 'contact-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>
