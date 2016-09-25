<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c0019".
 *
 * @property integer $ID
 * @property integer $USER_ID
 * @property string $TANGGAL_SYNC
 * @property string $TYPE_SYNC
 * @property string $WAKTU_SYNC
 * @property string $CREATE_AT
 * @property integer $CREATE_BY
 * @property string $UPDATE_AT
 * @property integer $UPDATE_BY
 */
class Whosync extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0019';
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
            [['USER_ID', 'TANGGAL_SYNC', 'TYPE_SYNC', 'WAKTU_SYNC'], 'required'],
            [['ID', 'USER_ID', 'CREATE_BY', 'UPDATE_BY'], 'integer'],
            [['TANGGAL_SYNC', 'WAKTU_SYNC', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['TYPE_SYNC'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'USER_ID' => 'User  ID',
            'TANGGAL_SYNC' => 'Tanggal  Sync',
            'TYPE_SYNC' => 'Type  Sync',
            'WAKTU_SYNC' => 'Waktu  Sync',
            'CREATE_AT' => 'Create  At',
            'CREATE_BY' => 'Create  By',
            'UPDATE_AT' => 'Update  At',
            'UPDATE_BY' => 'Update  By',
        ];
    }
}
