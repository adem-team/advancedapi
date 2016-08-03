<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c0009".
 *
 * @property string $ID
 * @property string $TGL
 * @property string $USER_ID
 * @property string $CUST_ID
 * @property integer $CHECK_IN
 * @property integer $START_PIC
 * @property integer $INVENTORY
 * @property integer $REQUEST
 * @property integer $END_PIC
 * @property integer $CHECK_OUT
 */
class Statuskunjungan extends \yii\db\ActiveRecord
{
    public function __construct()
    {
        $this->TGL = date('Y-m-d H:i:s');
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0009';
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
            [['TGL'], 'safe'],
            [['ID_DETAIL','CHECK_IN', 'START_PIC', 'INVENTORY_STOCK','INVENTORY_SELLIN','INVENTORY_SELLOUT','INVENTORY_EXPIRED','INVENTORY_RETURN', 'REQUEST', 'END_PIC', 'CHECK_OUT'], 'integer'],
            [['USER_ID', 'CUST_ID'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ID_DETAIL' => 'ID Detail',
            'TGL' => 'Tgl',
            'USER_ID' => 'User  ID',
            'CUST_ID' => 'Cust  ID',
            'CHECK_IN' => 'Check  In',
            'START_PIC' => 'Start  Pic',
            'INVENTORY_STOCK' => 'Inventory Stock',
            'INVENTORY_SELLIN' => 'Inventory Sellin',
            'INVENTORY_SELLOUT' => 'Inventory Sellout',
            'INVENTORY_EXPIRED' => 'Inventory Expired',
            'INVENTORY_RETURN' => 'Inventory Return',
            'REQUEST' => 'Request',
            'END_PIC' => 'End  Pic',
            'CHECK_OUT' => 'Check  Out',
        ];
    }
}
