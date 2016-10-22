<?php

namespace api\modules\lgerp\models;

use Yii;

/**
 * This is the model class for table "p0002".
 *
 * @property string $ID
 * @property string $KD_PO
 * @property string $KD_RO
 * @property string $KD_BARANG
 * @property string $NM_BARANG
 * @property string $UNIT
 * @property string $NM_UNIT
 * @property double $UNIT_QTY
 * @property double $UNIT_WIGHT
 * @property double $QTY
 * @property string $HARGA
 * @property string $KD_COSTCENTER
 * @property integer $STATUS
 * @property string $STATUS_DATE
 * @property string $NOTE
 */
class PurchaseDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p0002';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dev_db3');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_PO', 'KD_RO', 'KD_BARANG', 'NM_BARANG', 'UNIT', 'STATUS_DATE', 'NOTE'], 'required'],
            [['UNIT_QTY', 'UNIT_WIGHT', 'QTY', 'HARGA'], 'number'],
            [['STATUS'], 'integer'],
            [['STATUS_DATE'], 'safe'],
            [['NOTE'], 'string'],
            [['KD_PO', 'NM_UNIT', 'KD_COSTCENTER'], 'string', 'max' => 100],
            [['KD_RO'], 'string', 'max' => 50],
            [['KD_BARANG', 'NM_BARANG', 'UNIT'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_PO' => 'Kd  Po',
            'KD_RO' => 'Kd  Ro',
            'KD_BARANG' => 'Kd  Barang',
            'NM_BARANG' => 'Nm  Barang',
            'UNIT' => 'Unit',
            'NM_UNIT' => 'Nm  Unit',
            'UNIT_QTY' => 'Unit  Qty',
            'UNIT_WIGHT' => 'Unit  Wight',
            'QTY' => 'Qty',
            'HARGA' => 'Harga',
            'KD_COSTCENTER' => 'Kd  Costcenter',
            'STATUS' => 'Status',
            'STATUS_DATE' => 'Status  Date',
            'NOTE' => 'Note',
        ];
    }
}
