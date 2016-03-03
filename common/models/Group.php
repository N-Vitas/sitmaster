<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

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

    public function rules()
    {
        return [
            [['level'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
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