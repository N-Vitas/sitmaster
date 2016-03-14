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
class CommentTicket extends ActiveRecord
{
    public static function tableName()
    {
        return 'comment_ticket';
    }

    public static function modelTitle()
    {
        return 'CommentTicket';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ]
        ];


    }

    public function rules()
    {
        return [
            [['author_id', 'created_at','ticket_id','status'], 'integer'],
            [['ticket_id','text'], 'required'],
            [['text'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app','Id'),
            'author_id' => Yii::t('app','Автор'),
            'ticket_id' => Yii::t('app','Группа'),
            'text' => Yii::t('app','Текст'),
            'status' => Yii::t('app','Статус'),
            'created_at' => Yii::t('app','Дата создания'),
        ];
    } 
    public function getAuthorName(){
        $user = User::findOne($this->author_id);
        if($user)
        return $user->username;
        else
        return "Неназначена";
    }
}