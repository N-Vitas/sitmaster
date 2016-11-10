<?php
namespace frontend\models;

use common\models\User;
use common\models\Profile;
use common\models\UserGroup;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $name;
    public $location;
    public $phone;
    public $role_id;
    public $group;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['location', 'filter', 'filter' => 'trim'],
            ['location', 'string', 'min' => 2, 'max' => 255],

            ['phone', 'filter', 'filter' => 'trim'],
            ['phone', 'string', 'min' => 2, 'max' => 255],

            [['role_id'], 'integer'],

            [['group'], 'safe'],    
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
      if ($this->validate()) {
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->created_at = time();
        $user->updated_at = time();
        $user->setPassword($this->password);
        $user->role_id = $this->role_id;
        $user->generateAuthKey();
        if ($user->save()) {
          $profile = new Profile();
          $profile->user_id = $user->id;
          $profile->public_email = $this->email;
          $profile->gravatar_email = $this->email;
          $profile->name = $this->name;
          $profile->location = $this->location;
          $profile->phone = $this->phone;
          $profile->jobs = '';
          $profile->save();
          if(is_array($this->group)){
            foreach ($this->group as $key => $id) {
              $group = new UserGroup();
              $group->user_id = $user->id; 
              $group->group_id = $id;
              $group->save();
            }
          }else{
            $group = new UserGroup();
            $group->user_id = $user->id; 
            $group->group_id = $this->group;
            $group->save();  
          }      
          return $user;
        }
      }
      return null;
    }

    public function attributeLabels()
    {
      return [
        'id' => 'Порядоковый номер',
        'password' => 'Пароль',
        'username' => 'Логин',
        'email' => 'Email',
        'name' => 'Ф.И.О.',
        'location' => 'Адресс',
        'phone' => 'Телефон',
        'role_id' => 'Роль',
        'group' => 'Место работы',
      ];
    }
}
