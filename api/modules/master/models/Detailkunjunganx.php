<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c0002scdl_detail".
 *
 * @property string $ID
 * @property string $TGL
 * @property string $CUST_ID
 * @property string $USER_ID
 * @property string $SCDL_GROUP
 * @property double $LAT
 * @property double $LAG
 * @property double $RADIUS
 * @property string $NOTE
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 * @property string $CHECKIN_TIME
 * @property double $CHECKOUT_LAT
 * @property double $CHECKOUT_LAG
 * @property string $CHECKOUT_TIME
 */
class Detailkunjunganx extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0002scdl_detail';
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
            [['TGL', 'CREATE_AT', 'UPDATE_AT', 'CHECKIN_TIME', 'CHECKOUT_TIME'], 'safe'],
            [['SCDL_GROUP', 'STATUS'], 'integer'],
            [['LAT', 'LAG', 'RADIUS', 'CHECKOUT_LAT', 'CHECKOUT_LAG'], 'number'],
            [['NOTE'], 'string'],
            [['CUST_ID', 'USER_ID'], 'string', 'max' => 50],
            [['CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TGL' => 'Tgl',
            'CUST_ID' => 'Cust  ID',
            'USER_ID' => 'User  ID',
            'SCDL_GROUP' => 'Scdl  Group',
            'LAT' => 'Lat',
            'LAG' => 'Lag',
            'RADIUS' => 'Radius',
            'NOTE' => 'Note',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
            'CHECKIN_TIME' => 'Checkin  Time',
            'CHECKOUT_LAT' => 'Checkout  Lat',
            'CHECKOUT_LAG' => 'Checkout  Lag',
            'CHECKOUT_TIME' => 'Checkout  Time',
        ];
    }
}
