<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c0022header".
 *
 * @property string $ROAD_D
 * @property string $USER_ID
 * @property string $CASE_ID
 * @property string $CASE_NOTE
 * @property double $LAT
 * @property double $LAG
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 */
class Roadsalesheader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0022Header';
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
            [['CASE_ID', 'CASE_NOTE','CASE_NM','UUID'], 'string'],
            [['LAT', 'LAG'], 'number'],
            [['CREATED_AT','TGL'], 'safe'],
            [['CUSTOMER'], 'string', 'max' => 50],
            [['USER_ID','JUDUL'], 'string', 'max' => 50],
            [['CREATED_BY'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ROAD_D' => 'Road  D',
            'USER_ID' => 'User  ID',
            'CASE_ID' => 'Case  ID',
            'CASE_NOTE' => 'Case  Note',
            'JUDUL' => 'Judul',
            'CUSTOMER' => 'Customer',
            'CASE_NM' => 'Case Name',
            'LAT' => 'Lat',
            'LAG' => 'Lag',
            'TGL' => 'Tanggal',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UUID'=>'Uuid'
        ];
    }
}
