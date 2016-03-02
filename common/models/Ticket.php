<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Ticket extends ActiveRecord
{
    private $email = 'test@test.com';
    private $name = 'contra';
    // public $verifyCode;
    public static function tableName()
    {
        return 'ticket';
    }

    public static function modelTitle()
    {
        return 'Ticket';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ]];


    }

    public function rules()
    {
        return [
            [['user_id', 'agent_id', 'cat_level', 'cat_id', 'created_at', 'updated_at', 'closed_at', 'status'], 'integer'],
            [['title','user_id','text'], 'required'],
            [['text', 'json','files','callback'], 'string'],
            [['title', 'priorited'], 'string', 'max' => 255],
            // ['verifyCode', 'captcha'],
        ];
    }
    /*public function fields()
    {

        return [
            // field name is the same as the attribute name
            'id'=>function($model){
                return (int)$model->id;
            },            
            'parent_user_id' => 'parent_user_id',
            'status' => 'status',
            'text' => 'text',
            'url' => 'url',
            'like' => 'like',
            'comment' => 'comment',
            'created_at' => function($model){
                return date('d-m-Y H:i:s',$this->created_at);
            },
            'updated_at' => function($model){
                return date('d-m-Y H:i:s',$this->updated_at);
            },
            // field name is "name", its value is defined by a PHP callback
            'data' => function ($model){
                $array = (array)json_decode($model->data, true);
                return $array;
            },
            //'data'=>'data',
        ];
    }*/
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app','Id'),
            'user_id' => Yii::t('app','Пользователь'),
            'agent_id' => Yii::t('app','Специалист'),
            'cat_id' => Yii::t('app','Группа'),
            'cat_level' => Yii::t('app','Подгруппа'),
            'priorited' => Yii::t('app','Приоритет'),
            'title' => Yii::t('app','Тема'),
            'text' => Yii::t('app','Текст'),
            'files' => Yii::t('app','Файлы'),
            'json' => Yii::t('app','Доп. данные'),
            'status' => Yii::t('app','Статус'),
            'callback' => Yii::t('app','Ответ'),
            'created_at' => Yii::t('app','Дата создания'),
            'updated_at' => Yii::t('app','Дата обновления'),
            'closed_at' => Yii::t('app','Дата закрытия'),
            'verifyCode' => Yii::t('app','Проверочный код'),
        ];
    }    
    // public function beforeDelete()
    // {
    //     Newsline::deleteAll("post_id = ".$this->id);
    //     Yii::$app->elasticsearch->delete('/ironpal/post/'.$this->id);
    //     return true;
    // }

    // public function beforeValidate(){

    //     $data = json_decode($this->data,true);
    //     if(isset($data['subcategory'])){
    //         $this->expires_at = self::setLifeTime($data['subcategory']);
    //     }   
    //     // echo "<pre>";var_dump($this->created_at);die;
    //     return true;
    // }

    // public function afterSave($insert)
    // {
    //     $client = new \GearmanClient();
    //     $client->addServer(/*"127.0.0.1",47330*/);
    //     $client->setTimeout(29000);
    //     $data = $this->attributes;
    //     $data['insert'] = $insert;
    //     $data = json_encode($data);
    //     // Отправляем задачу и данные на Gearman и ждем выполнения
    //     $client->doBackground('worker_new_post', $data);
    //     return true;
    // }

    // public static function setLifeTime($subcategory,$time = null){
    //     if($time == null)
    //         $time = time();
    //     switch ($subcategory) {
    //         case 'Пробки' :
    //             return ($time+5*3600);
    //         case 'ДТП' :                
    //             return ($time+5*3600);
    //         case 'Парковки' :                
    //             return ($time+5*3600);
    //         case 'Смешное' :                
    //             return ($time+6*3600);
    //         case 'Ремонт' :                
    //             return ($time+5*3600);
    //         case 'Плохая дорога' :                
    //             return ($time+5*3600);
    //         case 'SOS' :                
    //             return ($time+5*3600);
    //         case 'Радары' :                
    //             return ($time+5*3600);            
    //         default:                
    //             return $time;
    //     }

    // }

    // public static function getSubcategoryList()
    // {
    //     return [
    //         'Пробки',
    //         'ДТП',
    //         'Парковки',
    //         'Смешное',
    //         'Ремонт',
    //         'Плохая дорога',
    //         'SOS',
    //         'Радары',
    //     ];
    // }
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->title)
            ->setTextBody($this->text)
            ->send();
    }

    public function getStatusColor(){
        switch ($this->status) {
            case 1:
                return "success";
            case 2:
                return "primary";
            case 3:
                return "danger";
            case 4:
                return "info";
            
            default:
                return "success";                
        }
    }

    public function getStatusName(){
        switch ($this->status) {
            case 1:
                return "Открыта";
            case 2:
                return "В ожидании";
            case 3:
                return "Приостановленная";
            case 4:
                return "Решена";
            
            default:
                return "Открыта";                
        }
    }

    public function getUserName(){
        $user = User::findOne($this->user_id);
        return $user->username;
    }
    public function getAgentName(){
        $user = User::findOne($this->agent_id);
        if($user)
        return $user->username;
        else
        return "Неназначена";
    }
}