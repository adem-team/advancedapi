<?php

namespace api\modules\lgerp\models;

use Yii;

/**
 * This is the model class for table "p0001".
 *
 * @property string $KD_PO
 * @property string $KD_CORP
 * @property integer $PARENT_PO
 * @property string $KD_SUPPLIER
 * @property string $ETD
 * @property string $ETA
 * @property string $DISCOUNT
 * @property string $PAJAK
 * @property string $BILLING
 * @property string $SHIPPING
 * @property string $DELIVERY_COST
 * @property string $TOP_TYPE
 * @property string $TOP_DURATION
 * @property string $NOTE
 * @property integer $STATUS
 * @property string $CREATE_AT
 * @property string $CREATE_BY
 * @property string $SIG1_ID
 * @property string $SIG1_NM
 * @property string $SIG1_TGL
 * @property string $SIG1_SVGBASE64
 * @property string $SIG1_SVGBASE30
 * @property string $SIG2_ID
 * @property string $SIG2_NM
 * @property string $SIG2_TGL
 * @property string $SIG2_SVGBASE64
 * @property string $SIG2_SVGBASE30
 * @property string $SIG3_ID
 * @property string $SIG3_NM
 * @property string $SIG3_TGL
 * @property string $SIG3_SVGBASE64
 * @property string $SIG3_SVGBASE30
 * @property string $SIG4_ID
 * @property string $SIG4_NM
 * @property string $SIG4_TGL
 * @property string $SIG4_SVGBASE64
 * @property string $SIG4_SVGBASE30
 */
class PurchaseOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p0001';
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
            [['KD_PO', 'ETD', 'ETA', 'DELIVERY_COST', 'NOTE', 'CREATE_AT', 'CREATE_BY'], 'required'],
            [['PARENT_PO', 'STATUS'], 'integer'],
            [['ETD', 'ETA', 'CREATE_AT', 'SIG1_TGL', 'SIG2_TGL', 'SIG3_TGL', 'SIG4_TGL'], 'safe'],
            [['DISCOUNT', 'PAJAK', 'DELIVERY_COST'], 'number'],
            [['NOTE', 'SIG1_SVGBASE64', 'SIG1_SVGBASE30', 'SIG2_SVGBASE64', 'SIG2_SVGBASE30', 'SIG3_SVGBASE64', 'SIG3_SVGBASE30', 'SIG4_SVGBASE64', 'SIG4_SVGBASE30'], 'string'],
            [['KD_PO', 'KD_CORP', 'KD_SUPPLIER', 'BILLING', 'SHIPPING', 'SIG1_ID', 'SIG1_NM', 'SIG2_ID', 'SIG2_NM', 'SIG3_NM', 'SIG4_ID', 'SIG4_NM'], 'string', 'max' => 50],
            [['TOP_TYPE', 'TOP_DURATION', 'SIG3_ID'], 'string', 'max' => 255],
            [['CREATE_BY'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'KD_PO' => 'Kd  Po',
            'KD_CORP' => 'Kd  Corp',
            'PARENT_PO' => 'Parent  Po',
            'KD_SUPPLIER' => 'Kd  Supplier',
            'ETD' => 'Etd',
            'ETA' => 'Eta',
            'DISCOUNT' => 'Discount',
            'PAJAK' => 'Pajak',
            'BILLING' => 'Billing',
            'SHIPPING' => 'Shipping',
            'DELIVERY_COST' => 'Delivery  Cost',
            'TOP_TYPE' => 'Top  Type',
            'TOP_DURATION' => 'Top  Duration',
            'NOTE' => 'Note',
            'STATUS' => 'Status',
            'CREATE_AT' => 'Create  At',
            'CREATE_BY' => 'Create  By',
            'SIG1_ID' => 'Sig1  ID',
            'SIG1_NM' => 'Sig1  Nm',
            'SIG1_TGL' => 'Sig1  Tgl',
            'SIG1_SVGBASE64' => 'Sig1  Svgbase64',
            'SIG1_SVGBASE30' => 'Sig1  Svgbase30',
            'SIG2_ID' => 'Sig2  ID',
            'SIG2_NM' => 'Sig2  Nm',
            'SIG2_TGL' => 'Sig2  Tgl',
            'SIG2_SVGBASE64' => 'Sig2  Svgbase64',
            'SIG2_SVGBASE30' => 'Sig2  Svgbase30',
            'SIG3_ID' => 'Sig3  ID',
            'SIG3_NM' => 'Sig3  Nm',
            'SIG3_TGL' => 'Sig3  Tgl',
            'SIG3_SVGBASE64' => 'Sig3  Svgbase64',
            'SIG3_SVGBASE30' => 'Sig3  Svgbase30',
            'SIG4_ID' => 'Sig4  ID',
            'SIG4_NM' => 'Sig4  Nm',
            'SIG4_TGL' => 'Sig4  Tgl',
            'SIG4_SVGBASE64' => 'Sig4  Svgbase64',
            'SIG4_SVGBASE30' => 'Sig4  Svgbase30',
        ];
    }
}
