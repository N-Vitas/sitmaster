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
class Profile extends ActiveRecord
{
    public static function tableName()
    {
        return 'profile';
    }

    public static function modelTitle()
    {
        return 'Profile';
    }

    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['user_id'], 'required'],
            [['bio'], 'string'],
            [['name','public_email','gravatar_email','gravatar_id','location','phone','website'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app','Пользователь'),
            'name' => Yii::t('app','Имя'),
            'public_email' => Yii::t('app','Публичный email'),
            'gravatar_email' => Yii::t('app','Дополнительный email'),
            'gravatar_id' => Yii::t('app','Аватар'),
            'location' => Yii::t('app','Адресс'),
            'phone' => Yii::t('app','Адресс'),
            'website' => Yii::t('app','Сайт'),
            'bio' => Yii::t('app','О себе'),
        ];
    } 
}