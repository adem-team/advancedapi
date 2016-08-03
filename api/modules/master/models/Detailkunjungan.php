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
 */
class Detailkunjungan extends \yii\db\ActiveRecord
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

    public function __construct()
    {
        $this->CREATE_AT = date('Y-m-d H:i:s');
        $this->UPDATE_AT = date('Y-m-d H:i:s');
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USER_ID','CUST_ID','TGL', 'CREATE_AT', 'UPDATE_AT'],'required'],
            [['TGL', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['SCDL_GROUP', 'STATUS','STATUS_CASE'], 'integer'],
            [['LAT', 'LAG', 'RADIUS'], 'number'],
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
        ];
    }
}
