<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;

/**
 * This is the model class for table "Item_formula".
 *
 * @property integer $ID_DTL_FORMULA
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 * @property integer $STATUS
 * @property integer $TYPE
 * @property string $TYPE_NM
 * @property integer $ID_STORE
 * @property integer $ID_ITEM
 * @property string $DISCOUNT_PESEN
 * @property string $DISCOUNT_WAKTU
 * @property integer $DISCOUNT_HARI
 */
class ItemFormula extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Item_formula';
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
            [['CREATE_AT', 'UPDATE_AT', 'DISCOUNT_WAKTU'], 'safe'],
            [['STATUS', 'TYPE', 'ID_STORE', 'ID_ITEM', 'DISCOUNT_HARI'], 'integer'],
            [['DISCOUNT_PESEN'], 'number'],
            [['CREATE_BY', 'UPDATE_BY', 'TYPE_NM'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_DTL_FORMULA' => Yii::t('app', 'RECEVED & RELEASE:
ID UNIX, POSTING URL DAN AJAX'),
            'CREATE_BY' => Yii::t('app', 'USER CREATED'),
            'CREATE_AT' => Yii::t('app', 'Tanggal dibuat'),
            'UPDATE_BY' => Yii::t('app', 'USER UPDATE'),
            'UPDATE_AT' => Yii::t('app', 'Tanggal di update'),
            'STATUS' => Yii::t('app', 'Status'),
            'TYPE' => Yii::t('app', 'Type'),
            'TYPE_NM' => Yii::t('app', 'Type  Nm'),
            'ID_STORE' => Yii::t('app', 'Id  Store'),
            'ID_ITEM' => Yii::t('app', 'Id  Item'),
            'DISCOUNT_PESEN' => Yii::t('app', 'Discount  Pesen'),
            'DISCOUNT_WAKTU' => Yii::t('app', 'Discount  Waktu'),
            'DISCOUNT_HARI' => Yii::t('app', 'Discount  Hari'),
        ];
    }
}
