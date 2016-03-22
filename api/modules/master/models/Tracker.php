<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c0008".
 *
 * @property string $ID
 * @property string $TGL
 * @property string $USER_ID
 * @property double $LAT
 * @property double $LAG
 */
class Tracker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0008';
    }
    public function __construct()
    {
        $this->TGL = date('Y-m-d H:i:s');
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
            [['TGL'], 'safe'],
            [['LAT', 'LAG'], 'number'],
            [['USER_ID'], 'string', 'max' => 50]
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
            'LAT' => 'Lat',
            'LAG' => 'Lag',
        ];
    }
}
