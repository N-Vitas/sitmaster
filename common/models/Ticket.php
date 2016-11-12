<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use \common\models\Group;
use yii\web\UploadedFile;

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
    private $email = 'nikonov.vitas@gmail.com';
    private $name = 'support.sitmaster.kz';    
    public $file;
    private $path;
    public $url = 'uploads';
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
            ]
        ];


    }

    public function rules()
    {
        return [
            [['user_id', 'agent_id', 'created_at','cat_level', 'cat_id', 'updated_at', 'closed_at', 'status'], 'integer'],
            [['title','user_id','text','priorited'], 'required'],
            [['text', 'json','files','callback'], 'string'],
            [['title', 'priorited'], 'string', 'max' => 255],
            [['file'], 'file', 'extensions' => 'gif, jpg, png, jpeg','maxSize' => 15048576],
            // ['verifyCode', 'captcha'],
        ];
    }

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
            'file' => Yii::t('app','Файлы'),
            'json' => Yii::t('app','Доп. данные'),
            'status' => Yii::t('app','Статус'),
            'callback' => Yii::t('app','Ответ'),
            'created_at' => Yii::t('app','Дата создания'),
            'updated_at' => Yii::t('app','Дата обновления'),
            'closed_at' => Yii::t('app','Дата закрытия'),
            'verifyCode' => Yii::t('app','Проверочный код'),
        ];
    }   

    public function beforeValidate(){
        if(!is_array($this->cat_level) or !is_array($this->cat_id) ){
            if($this->cat_id > 0){
                $group = Group::findOne($this->cat_id);
                $this->cat_level = $group->level;
            }
        }
        if($this->file){
            $this->files = "/".$this->url."/".$this->file;
        }
        return true;
    }

    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose(/*['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user]*/)
            ->setTo($email)
            ->setFrom([\Yii::$app->params['supportEmail'] => $this->name])
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
                return "В работе";
            case 3:
                return "Приостановленная";
            case 4:
                return "Решена";
            
            default:
                return "Открыта";                
        }
    }

    public function getGroupName(){
        $group = Group::findOne($this->cat_id);
        return $group->title;
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