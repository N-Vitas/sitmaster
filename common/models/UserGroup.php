<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/*
 *
 */
class UserGroup extends ActiveRecord
{

    public static function tableName()
    {
        return 'user_group';
    }

    public static function modelTitle()
    {
        return 'Список групп пользователя';
    }

    public function rules()
    {
        return [
            [['user_id','group_id'], 'integer'],
            [['user_id','group_id'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app','Id'),
            'user_id' => Yii::t('app','Пользователь'),
            'group_id' => Yii::t('app','Группа'),
        ];
    }   
}