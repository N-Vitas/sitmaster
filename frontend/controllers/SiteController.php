<?php
namespace frontend\controllers;

use Yii;
use yii\web\UploadedFile;
use common\models\LoginForm;
use common\models\CommentTicket;
use common\models\Ticket;
use common\models\Group;
use common\models\User;
use common\models\UserGroup;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\TicketSearch;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use frontend\components\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class SiteController extends Controller
{   

    public function actionIndex()
    {
        // $models = Ticket::find()->all();
        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',compact('dataProvider','searchModel'));
    }

    public function actionCosed($id){
        if(Yii::$app->user->identity->role_id >3){
            $model = Ticket::findOne($id);
            $model->status = 4;
            if($model->save()){
                $this->sendChange($model,'change-status');
            }
        }
        $this->redirect('/site/page/'.$id);
    }
    public function actionStatuschange($id){
        if(Yii::$app->user->identity->role_id >3){
            $model = Ticket::findOne($id);
            $model->status = Yii::$app->request->post('status');
            if($model->save()){
                $this->sendChange($model,'change-status');
            }
        }
        $this->redirect('/site/page/'.$id);
    }
    public function actionSetagent($id){
        if(Yii::$app->user->identity->role_id >3){
            $model = Ticket::findOne($id);
            $model->agent_id = Yii::$app->user->id;
            if($model->save()){
                $this->sendChange($model,'change-agent');
            }
        }
        $this->redirect('/site/page/'.$id);
    }

    private function sendChange($model,$template){
        $author = User::findOne($model->user_id);
        if($author){                   
            return Yii::$app->mailer->compose(['html' => $template.'-html', 'text' => $template.'-text'], ['model' => $model,'author'=> $author])
            ->setTo($author->email)
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name.' robot'])
            ->setSubject('Изменения в заявке № '.$model->id)
            ->send();
        }
        return false;
    }
    
    public function actionCreate()
    {
        $model = new Ticket();
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if($model->file && $model->save()){
                $model->file->saveAs('uploads/' . $model->file->baseName . '.' . $model->file->extension);
            
                if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                    Yii::$app->session->setFlash('success', 'Заявка успешно создана. Благодарим Вас за использование нашего сервиса.');
                } else {
                    Yii::$app->session->setFlash('error', 'Произошла ошибка отправки письма.');
                }
                return $this->refresh();
            }
            else if($model->save()){
                if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                    Yii::$app->session->setFlash('success', 'Заявка успешно создана. Благодарим Вас за использование нашего сервиса.');
                } else {
                    Yii::$app->session->setFlash('error', 'Произошла ошибка отправки письма.');
                }
                return Yii::$app->response->redirect(['site/index']); //$this->refresh();
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);                
            }
        }
        return $this->render('create',compact('model'));
    }

    public function actionPage($id)
    {
        $model = new CommentTicket();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            return $this->refresh();
        }
        $ticket = Ticket::findOne((int) $id);
        $query = CommentTicket::find()->where(['ticket_id'=> $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_ASC]]
        ]);
        return $this->render('page',compact('model','ticket','dataProvider'));
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionGroup(){
      if(gettype(Yii::$app->request->post("create")) == 'string'
          && Yii::$app->request->post("group") != ''
        ){
        $group = new Group();
        $group->level = Yii::$app->request->post("level");
        $group->title = Yii::$app->request->post("group");
        if($group->save()){
          Yii::$app->session->setFlash('success', 'Новая группа создана.');          
        }
        else
          Yii::$app->session->setFlash('error', 'Ошибка сохранения.');
      }
      return $this->render('group');
    }
    public function actionAbout()
    {
      if(Yii::$app->user->identity->role_id < 3){
        return $this->render('error',['message'=>"Страница не найдена.",'name'=>'Not Found (#404)']);
      }
      $levelUp = Group::find()->where(['level'=>0])->all();
        foreach ($levelUp as $group) {
          if(UserGroup::find()->where(['user_id'=>Yii::$app->user->identity->id,'group_id'=>$group->id])->count()){
            $leveDown = Group::find()->where(['level'=>$group->id])->all();
            $open  = Ticket::find()->where(['cat_id'=>$group->id,'status'=>1])->count();
            $wait  = Ticket::find()->where(['cat_id'=>$group->id,'status'=>2])->count();
            $stop  = Ticket::find()->where(['cat_id'=>$group->id,'status'=>3])->count();
            $close = Ticket::find()->where(['cat_id'=>$group->id,'status'=>4])->count();
            $total = Ticket::find()->where(['cat_id'=>$group->id])->count();
            $statistic[] = [
              'title' => $group->title,
              'open'  => $open,
              'wait'  => $wait,
              'stop'  => $stop,
              'close' => $close,
              'total' => $total,
            ]; 
            foreach ($leveDown as $down) {
              $l_open  = Ticket::find()->where(['cat_id'=>$down->id,'status'=>1])->count();
              $l_wait  = Ticket::find()->where(['cat_id'=>$down->id,'status'=>2])->count();
              $l_stop  = Ticket::find()->where(['cat_id'=>$down->id,'status'=>3])->count();
              $l_close = Ticket::find()->where(['cat_id'=>$down->id,'status'=>4])->count();
              $l_total = Ticket::find()->where(['cat_id'=>$down->id])->count();
              $statistic[] = [
                'title' => $down->title,
                'open'  => $l_open,
                'wait'  => $l_wait,
                'stop'  => $l_stop,
                'close' => $l_close,
                'total' => $l_total,
              ];             
              $open  += $l_open;
              $wait  += $l_wait;
              $stop  += $l_stop;
              $close += $l_close;
              $total += $l_total;
            } 
            $statistic[] = [
              'title' => '(Общее) '.$group->title,
              'open'  => $open,
              'wait'  => $wait,
              'stop'  => $stop,
              'close' => $close,
              'total' => $total,
            ]; 
            unset($open);
            unset($wait);
            unset($stop);
            unset($close);
            unset($total);
        }
      }
        // var_dump($statistic);die;
        return $this->render('about',['statistic'=>$statistic]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
