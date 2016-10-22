<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "b0001".
 *
 * @property string $ID
 * @property string $KD_CORP
 * @property string $KD_TYPE
 * @property string $KD_KATEGORI
 * @property string $KD_BARANG
 * @property string $NM_BARANG
 * @property string $KD_UNIT
 * @property integer $STATUS
 * @property integer $PARENT
 * @property string $KD_SUPPLIER
 * @property string $HARGA_SPL
 * @property string $HARGA_PABRIK
 * @property string $HARGA_LG
 * @property string $HARGA_DIST
 * @property string $HARGA_SALES
 * @property string $IMAGE
 * @property string $NOTE
 * @property string $KD_CAB
 * @property string $KD_DEP
 * @property string $BARCODE64BASE
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_BY
 * @property string $UPDATED_AT
 * @property string $DATA_ALL
 */
class Barangpenjualan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b0001';
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
            [['KD_CORP', 'KD_BARANG', 'NM_BARANG', 'IMAGE'], 'required'],
            // [['KD_CORP', 'KD_BARANG', 'NM_BARANG', 'IMAGE', 'NOTE', 'KD_CAB', 'KD_DEP', 'BARCODE64BASE', 'CREATED_BY', 'CREATED_AT', 'UPDATED_BY', 'UPDATED_AT', 'DATA_ALL'], 'required'],
            [['STATUS', 'PARENT'], 'integer'],
            [['HARGA_SPL', 'HARGA_PABRIK', 'HARGA_LG', 'HARGA_DIST', 'HARGA_SALES'], 'number'],
            [['NOTE', 'BARCODE64BASE'], 'string'],
            [['IMAGE'], 'safe'],
            [['KD_CORP', 'KD_BARANG', 'KD_SUPPLIER', 'KD_CAB', 'KD_DEP'], 'string', 'max' => 50],
            [['KD_TYPE', 'KD_KATEGORI'], 'string', 'max' => 10],
            [['NM_BARANG', 'CREATED_BY', 'CREATED_AT', 'UPDATED_BY', 'UPDATED_AT', 'DATA_ALL'], 'string', 'max' => 255],
            [['KD_UNIT'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_CORP' => 'Kd  Corp',
            'KD_TYPE' => 'Kd  Type',
            'KD_KATEGORI' => 'Kd  Kategori',
            'KD_BARANG' => 'Kd  Barang',
            'NM_BARANG' => 'Nm  Barang',
            'KD_UNIT' => 'Kd  Unit',
            'STATUS' => 'Status',
            'PARENT' => 'Parent',
            'KD_SUPPLIER' => 'Kd  Supplier',
            'HARGA_SPL' => 'Harga  Spl',
            'HARGA_PABRIK' => 'Harga  Pabrik',
            'HARGA_LG' => 'Harga  Lg',
            'HARGA_DIST' => 'Harga  Dist',
            'HARGA_SALES' => 'Harga  Sales',
            'IMAGE' => 'Image',
            'NOTE' => 'Note',
            'KD_CAB' => 'Kd  Cab',
            'KD_DEP' => 'Kd  Dep',
            'BARCODE64BASE' => 'Barcode64 Base',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_AT' => 'Updated  At',
            'DATA_ALL' => 'Data  All',
        ];
    }
}
