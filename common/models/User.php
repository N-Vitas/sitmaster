<?php
namespace common\models;

use Yii;
use dektrium\user\models\User as BaseUser;
use \common\models\Post;
use \common\models\Profile;
use \common\models\Token;

class User extends BaseUser
{

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
    public function scenarios()
    {
        return [
                'default'  => ['email'],
                'register' => ['username', 'email', 'password'],
                'connect'  => ['username', 'email'],
                'create'   => ['username', 'email', 'password'],
                'update'   => ['username', 'email', 'password'],
                'settings' => ['username', 'email', 'password']
            ];
    }

    public function rules()
    {
        return [
                ['username', 'required', 'on' => ['register', 'connect', 'create', 'update']],
                ['username', 'match', 'pattern' => '/^[a-zA-Z]\w+$/'],
                ['username', 'string', 'min' => 3, 'max' => 25],
                ['username', 'unique'],
                ['username', 'trim'],

                ['apikey','string','max' => 32],

                ['email', 'required', 'on' => ['register', 'connect', 'create', 'update']],
                ['email', 'email'],
                ['email', 'string', 'max' => 255],
                ['email', 'unique'],
                ['email', 'trim'],

                ['password', 'required', 'on' => ['register']],
                ['password', 'string', 'min' => 6, 'on' => ['register', 'create']],
            ];
    }
    public function attributes()
    {
        return ['id', 'username', 'email','password_hash','auth_key','confirmed_at','created_at','updated_at','flags','user_info','registration_ip','password_reset_token'];
    }
    public function getProfile()
    {
        return $this->hasOne(Profile::className(),['user_id'=>'id']);
    }
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }
    public static function findByPasswordResetToken($token)
    {
        return static::findOne(['password_reset_token' => $token]);
    }
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function getUsername($id)
    {
        $username = static::findOne(['id' => $id]);
        return $username->username;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    public function generateApiKey()
    {
        $this->apikey = Yii::$app->security->generateRandomString();
    }
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString().'_'.time();
    }
    public function removePasswordResetToken(){
        $this->password_reset_token = 0;
    }
    //тест связи пользователя с постом.
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['parent_user_id' => 'id']);   
    }


    public static function getToken($token, $type = null)
    {
        return Token::findOne(['code'=>$token]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $tokenModel = self::getToken($token,$type);
        if($tokenModel && !$tokenModel->getIsExpired()){
            return self::findOne(['id'=>$tokenModel->user_id]);
        }

        return null;
    }

    public function generateToken($type=false)
    {
        if (!$type) {
            $type = Token::TYPE_APPLICATION;
        }
        $token = new Token();
        $token->user_id = $this->id;
        $token->type = $type;
        if($token->save()){
            return $token;
        }

        return null;
    }
    
    public function beforeDelete()
    {
        Yii::$app->elasticsearch->delete('/ironpal/user/'.$this->id); 
        return true;
    }

    public function reindexElastica()
    {
        $data = [];
        $user = $this;
        if($user->profile) {
            $user->user_info = $user->profile->attributes;
        }
        $data = $user->attributes;
        if($user->user_info) {
            $data['search'] = [];
            foreach ($user->profile->attributes as $attribute => $vl) {
                $data['search'][] = $vl;
            }
            $data['search'] = implode(' ',$data['search']);
        }

        Yii::$app->elasticsearch->put('/ironpal/user/'.$this->id,[],json_encode($data));
    }

 public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('auth_key', \Yii::$app->security->generateRandomString());
            if (\Yii::$app instanceof \yii\web\Application) {
                $this->setAttribute('registration_ip', null/*\Yii::$app->request->userIP*/);
            }
        }

        if (!empty($this->password)) {
            $this->setAttribute('password_hash', \dektrium\user\helpers\Password::hash($this->password));
        }

        return true;
    }
    public function afterSave($insert)
    {
        $this->reindexElastica();
        return true;
    }
}
