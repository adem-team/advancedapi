<?php

namespace api\modules\notify\models;

use Yii;

class Deptsub extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'u0002b';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DEP_SUB_ID', 'DEP_ID', 'DEP_SUB_STS'], 'required'],
            [['DEP_SUB_STS', 'SORT'], 'integer'],
            [['DEP_SUB_DCRP'], 'string'],
            [['DEP_SUB_ID'], 'string', 'max' => 6],
            [['DEP_ID'], 'string', 'max' => 20],
            [['DEP_SUB_NM', 'DEP_SUB_AVATAR'], 'string', 'max' => 50]
        ];
    }

  
    public function attributeLabels()
    {
        return [
            'DEP_SUB_ID' => 'DepSub.ID',
            'DEP_ID' => 'Dep  ID',
            'DEP_SUB_NM' => 'Dept.Sub',
            'DEP_SUB_STS' => 'Dep  Sub  Sts',
            'DEP_SUB_AVATAR' => 'Dep  Sub  Avatar',
            'DEP_SUB_DCRP' => 'Dep  Sub  Dcrp',
            'SORT' => 'Sort',
        ];
    }
}
