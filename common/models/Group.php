<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\UserGroup;
use common\models\User;
/*
 *
 */
class Group extends ActiveRecord
{

  public static function tableName()
  {
    return 'group';
  }

  public static function modelTitle()
  {
    return 'Группа';
  }

  public function fields()
  {
    return [
      'id',
      'level',
      'title',
      'childGroup'=>function($model){
        return  self::find()->where(['level'=>$model->id])->all();
      }
    ];
  }

  public function rules()
  {
    return [
      [['level'], 'integer'],
      [['title'], 'string', 'max' => 255],
      [['level','title'], 'required'],
    ];
  }

  public function afterSave($insert,$changedAttributes){
    if($insert){
      $users = User::find()->where(['role_id' => 4])->all();
      foreach ($users as $user) {
        $groupUser = new UserGroup();
        $groupUser->user_id = $user->id;
        $groupUser->group_id = $this->id;
        $groupUser->save();        
      }
    }
    parent::afterSave($insert, $changedAttributes);
  }

  public function attributeLabels()
  {
    return [
      'id' => Yii::t('app','Id'),
      'level' => Yii::t('app','Подгруппа'),
      'title' => Yii::t('app','Название'),
    ];
  }   
}