<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "ub0001".
 *
 * @property string $id
 * @property string $kdUnit
 * @property string $nmUnit
 * @property string $qty
 * @property integer $size
 * @property integer $weight
 * @property string $color
 * @property string $NOTE
 * @property integer $status
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_at
 */
class Unitbarang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dbc002.ub0001';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_UNIT', 'NM_UNIT', 'QTY'], 'required'],
            [['QTY'], 'integer'],
            [['NOTE','SIZE', 'WEIGHT', 'COLOR', 'NOTE', 'STATUS', 'CREATED_BY', 'CREATED_AT', 'UPDATED_AT', 'UPDATED_BY'], 'string'],
            [['KD_UNIT'], 'string', 'max' => 25],
            [['NM_UNIT'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_UNIT' => 'Kode Unit',
            'NM_UNIT' => 'Nama Unit',
            'QTY' => 'Jumlah',
            'SIZE' => 'Ukuran',
            'WEIGHT' => 'Berat',
            'COLOR' => 'Warna',
            'NOTE' => 'Catatan',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created By',
            'CREATED_AT' => 'Created At',
            'UPDATED_AT' => 'Updated At',
        ];
    }
}
