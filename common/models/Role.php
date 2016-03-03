<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/*
 *
 */
class Role extends ActiveRecord
{

    public static function tableName()
    {
        return 'role';
    }

    public static function modelTitle()
    {
        return 'Роль';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app','Id'),
            'title' => Yii::t('app','Название'),
        ];
    }   
}