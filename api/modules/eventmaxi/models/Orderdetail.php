<?php

namespace api\modules\eventmaxi\models;

use Yii;

/**
 * This is the model class for table "od0001".
 *
 * @property integer $ID
 * @property string $KD_PRODUCT
 * @property integer $JLH_ITEM
 * @property integer $HARGA_ITEM
 * @property string $KD_ORDER
 * @property string $CREATE_AT
 * @property integer $CREATE_BY
 * @property string $UPDATE_AT
 * @property integer $UPDATE_BY
 * @property integer $STATUS
 */
class Orderdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'od0001';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbevent');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_PRODUCT', 'JLH_ITEM', 'HARGA_ITEM', 'KD_ORDER', 'CREATE_AT', 'CREATE_BY', 'UPDATE_AT', 'UPDATE_BY', 'NM_PRODUCT'], 'required'],
            [['JLH_ITEM', 'HARGA_ITEM', 'CREATE_BY', 'UPDATE_BY', 'STATUS'], 'integer'],
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['KD_PRODUCT', 'NM_PRODUCT','KD_ORDER'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_PRODUCT' => 'Kd  Product',
            'NM_PRODUCT' => 'Nm  Product',
            'JLH_ITEM' => 'Jlh  Item',
            'HARGA_ITEM' => 'Harga  Item',
            'KD_ORDER' => 'Kd  Order',
            'CREATE_AT' => 'Create  At',
            'CREATE_BY' => 'Create  By',
            'UPDATE_AT' => 'Update  At',
            'UPDATE_BY' => 'Update  By',
            'STATUS' => 'Status',
        ];
    }
}
