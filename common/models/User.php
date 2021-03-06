<?php
namespace common\models;

use Yii;
use dektrium\user\models\User as BaseUser;
use \common\models\Profile;
use \common\models\Token;
use \common\models\UserGroup;
use \common\models\Group;


class User extends BaseUser
{

    public $user_info;

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
                // ['email', 'unique'],
                ['email', 'trim'],

                ['password', 'required', 'on' => ['register']],
                ['password', 'string', 'min' => 6, 'on' => ['register', 'create']],
            ];
    }    

    public function fields(){
        return [
           'id',
           'role_id',
           'cat_id',
           'cat_level',
           'username',
           'email',
           'auth_key',
           'profile'=>function($model){
                return array_merge([
                    'name' => $model->profile->name,
                    'phone' => $model->profile->phone,
                    'location' => $model->profile->location,
                ]);
           }
        ];
    }

    public function attributes()
    {
        return ['id', 'role_id','cat_id','cat_level','username', 'email','password_hash','auth_key','confirmed_at','created_at','updated_at','flags','user_info','registration_ip','password_reset_token'];
    }
    public function getProfile()
    {
        return $this->hasOne(Profile::className(),['user_id'=>'id']);
    }
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username,'flags'=>0]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email,'flags'=>0]);
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

    public static function getToken($token, $type = null)
    {
        return Token::findOne(['code'=>$token]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token,'flags'=>0]);
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
    
    public function getRoleName()
    {
        $role = \common\models\Role::findOne($this->role_id);
        return $role->title;  
        // return 'test';
    }
    public function getGroups(){
        $user_groups = UserGroup::find()->where(['user_id'=>$this->id])->all();
        if($user_groups){
            foreach ($user_groups as $user_group) {
                $group_id[] = $user_group->group_id;                
            }
            $groups = Group::find()->where(['id' => $group_id,'level' => 0])->all();
            if($groups)
                return $groups;
            $groups = Group::find()->where(['id' => $group_id])->all();            
            return $groups;
        }
        else
            return false;
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'Порядоковый номер',
            'created_at' => 'Дата создания',
            'username' => 'Логин',
            'email' => 'Email',
        ];
    }
}
