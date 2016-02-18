<?php

namespace crm\sistem\models;

use Yii;

/**
 * This is the model class for table "user_pos".
 *
 * @property integer $POSITION_LOGIN
 * @property string $POSITION_NM
 */
class Userpos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_pos';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POSITION_NM'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'POSITION_LOGIN' => 'Position  Login',
            'POSITION_NM' => 'Position  Nm',
        ];
    }
}
