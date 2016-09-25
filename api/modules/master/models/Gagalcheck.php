<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c0017".
 *
 * @property integer $ID
 * @property integer $ID_AGENDA
 * @property integer $USER_ID
 * @property string $ID_CUSTOMER
 * @property string $WAKTU_CHECK
 * @property string $TYPE_CHECK
 * @property string $POS_LAT
 * @property string $POS_LAG
 * @property integer $STATUS
 * @property string $CREATE_AT
 * @property integer $CREATE_BY
 * @property string $UPDATE_AT
 * @property integer $UPDATE_BY
 */
class Gagalcheck extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0017';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db3');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_AGENDA', 'USER_ID', 'ID_CUSTOMER', 'WAKTU_CHECK', 'TYPE_CHECK', 'POS_LAT', 'POS_LAG'], 'required'],
            [['ID_AGENDA', 'USER_ID', 'STATUS', 'CREATE_BY', 'UPDATE_BY'], 'integer'],
            [['WAKTU_CHECK', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['ID_CUSTOMER', 'TYPE_CHECK','POS_LAT', 'POS_LAG'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ID_AGENDA' => 'Id  Agenda',
            'USER_ID' => 'User  ID',
            'ID_CUSTOMER' => 'Id  Customer',
            'WAKTU_CHECK' => 'Waktu  Check',
            'TYPE_CHECK' => 'Type  Check',
            'POS_LAT' => 'Pos  Lat',
            'POS_LAG' => 'Pos  Lag',
            'STATUS' => 'Status',
            'CREATE_AT' => 'Create  At',
            'CREATE_BY' => 'Create  By',
            'UPDATE_AT' => 'Update  At',
            'UPDATE_BY' => 'Update  By',
        ];
    }
}
