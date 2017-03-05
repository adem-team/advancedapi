<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;

/**
 * This is the model class for table "transaksi".
 *
 * @property integer $ID
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 * @property integer $STATUS
 * @property string $TRANS_ID
 * @property integer $TRANS_TYPE
 * @property string $TRANS_DATE
 * @property string $USER_ID
 * @property string $OUTLET_ID
 * @property string $OUTLET_NM
 * @property string $CONSUMER_NM
 * @property string $CONSUMER_EMAIL
 * @property string $CONSUMER_PHONE
 * @property string $ITEM_ID
 * @property string $ITEM_NM
 * @property integer $ITEM_QTY
 * @property string $ITEM_HARGA
 * @property string $ITEM_DISCOUNT
 * @property string $ITEM_DISCOUNT_TIME
 */
class Transaksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaksi';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_efenbi');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CREATE_AT', 'UPDATE_AT', 'TRANS_DATE'], 'safe'],
            [['STATUS', 'TRANS_TYPE', 'ITEM_QTY'], 'integer'],
            [['ITEM_HARGA', 'ITEM_DISCOUNT'], 'number'],
            [['CREATE_BY', 'UPDATE_BY', 'TRANS_ID', 'OUTLET_ID', 'CONSUMER_PHONE', 'ITEM_ID'], 'string', 'max' => 50],
            [['USER_ID', 'OUTLET_NM', 'CONSUMER_NM', 'ITEM_NM', 'ITEM_DISCOUNT_TIME'], 'string', 'max' => 100],
            [['CONSUMER_EMAIL'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'CREATE_BY' => Yii::t('app', 'CREATE_BY'),
            'CREATE_AT' => Yii::t('app', 'CREATE_AT'),
            'UPDATE_BY' => Yii::t('app', 'UPDATE_BY'),
            'UPDATE_AT' => Yii::t('app', 'UPDATE_AT'),
            'STATUS' => Yii::t('app', 'STATUS'),
            'TRANS_ID' => Yii::t('app', 'TRANS_ID'),
            'TRANS_TYPE' => Yii::t('app', 'TYPE'),
            'TRANS_DATE' => Yii::t('app', 'DATE'),
            'USER_ID' => Yii::t('app', 'USER'),
            'OUTLET_ID' => Yii::t('app', 'OUTLET.ID'),
            'OUTLET_NM' => Yii::t('app', 'OUTLET'),
            'CONSUMER_NM' => Yii::t('app', 'CONSUMER'),
            'CONSUMER_EMAIL' => Yii::t('app', 'E-MAIL'),
            'CONSUMER_PHONE' => Yii::t('app', 'PHONE'),
            'ITEM_ID' => Yii::t('app', 'ITEM.ID'),
            'ITEM_NM' => Yii::t('app', 'ITEM'),
            'ITEM_QTY' => Yii::t('app', 'QTY'),
            'ITEM_HARGA' => Yii::t('app', 'PRICE'),
            'ITEM_DISCOUNT' => Yii::t('app', 'DISCOUNT'),
            'ITEM_DISCOUNT_TIME' => Yii::t('app', 'TIME DISCOUNT'),
        ];
    }
}
