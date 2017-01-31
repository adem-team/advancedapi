<?php

namespace api\modules\chart\models;

use Yii;

/**
 * This is the model class for table "c0023".
 *
 * @property string $ID
 * @property string $CUST_ID
 * @property string $CUST_NM
 * @property string $PROMO
 * @property string $TGL_START
 * @property string $TGL_END
 * @property integer $OVERDUE
 * @property string $MEKANISME
 * @property string $KOMPENSASI
 * @property string $KETERANGAN
 * @property integer $STATUS
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_BY
 * @property string $UPDATED_AT
 */
class Promo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0023';
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
            [['PROMO', 'MEKANISME', 'KOMPENSASI', 'KETERANGAN'], 'string'],
            [['TGL_START', 'TGL_END', 'CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['OVERDUE', 'STATUS'], 'integer'],
            [['CUST_ID'], 'string', 'max' => 50],
            [['CUST_NM'], 'string', 'max' => 255],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CUST_ID' => 'Cust  ID',
            'CUST_NM' => 'Cust  Nm',
            'PROMO' => 'Promo',
            'TGL_START' => 'Tgl  Start',
            'TGL_END' => 'Tgl  End',
            'OVERDUE' => 'Overdue',
            'MEKANISME' => 'Mekanisme',
            'KOMPENSASI' => 'Kompensasi',
            'KETERANGAN' => 'Keterangan',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_AT' => 'Updated  At',
        ];
    }
}
