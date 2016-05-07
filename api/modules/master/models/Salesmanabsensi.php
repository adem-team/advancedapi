<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c0015".
 *
 * @property integer $ID
 * @property string $TGL
 * @property integer $USER_ID
 * @property string $USER_NM
 * @property string $WAKTU_MASUK
 * @property string $LATITUDE_MASUK
 * @property string $LONG_MASUK
 * @property string $WAKTU_KELUAR
 * @property string $LATITUDE_KELUAR
 * @property string $LONG_KELUAR
 * @property integer $CREATE_BY
 * @property string $CREATE_AT
 * @property integer $UPDATE_BY
 * @property string $UPDATE_AT
 * @property integer $STATUS
 * @property string $SRC_ID
 * @property string $SRC_NM
 */
class Salesmanabsensi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0015';
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
            [['TGL', 'WAKTU_MASUK', 'WAKTU_KELUAR', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['USER_ID', 'CREATE_BY', 'UPDATE_BY', 'STATUS'], 'integer'],
            [['USER_NM'], 'string', 'max' => 255],
            [['LATITUDE_MASUK', 'LONG_MASUK', 'LATITUDE_KELUAR', 'LONG_KELUAR', 'SRC_ID', 'SRC_NM'], 'string', 'max' => 50]
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
            'USER_ID' => 'User  ID',
            'USER_NM' => 'User  Nm',
            'WAKTU_MASUK' => 'Waktu  Masuk',
            'LATITUDE_MASUK' => 'Latitude  Masuk',
            'LONG_MASUK' => 'Long  Masuk',
            'WAKTU_KELUAR' => 'Waktu  Keluar',
            'LATITUDE_KELUAR' => 'Latitude  Keluar',
            'LONG_KELUAR' => 'Long  Keluar',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
            'STATUS' => 'Status',
            'SRC_ID' => 'Src  ID',
            'SRC_NM' => 'Src  Nm',
        ];
    }
}
