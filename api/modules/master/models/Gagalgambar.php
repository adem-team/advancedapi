<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c0018".
 *
 * @property integer $ID
 * @property integer $ID_AGENDA
 * @property integer $USER_ID
 * @property string $ID_CUSTOMER
 * @property string $WAKTU_GAMBAR
 * @property string $TYPE_GAMBAR
 * @property string $ISI_GAMBAR
 * @property string $CREATE_AT
 * @property integer $CREATE_BY
 * @property string $UPDATE_AT
 * @property integer $UPDATE_BY
 * @property integer $STATUS
 */
class Gagalgambar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0018';
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
            [['ID_AGENDA', 'USER_ID', 'ID_CUSTOMER', 'WAKTU_GAMBAR', 'TYPE_GAMBAR', 'ISI_GAMBAR'], 'required'],
            [['ID_AGENDA', 'USER_ID', 'CREATE_BY', 'UPDATE_BY', 'STATUS'], 'integer'],
            [['WAKTU_GAMBAR', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['ISI_GAMBAR'], 'string'],
            [['ID_CUSTOMER', 'TYPE_GAMBAR'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ID_AGENDA' => 'Id  Agenda',
            'USER_ID' => 'User  ID',
            'ID_CUSTOMER' => 'Id  Customer',
            'WAKTU_GAMBAR' => 'Waktu  Gambar',
            'TYPE_GAMBAR' => 'Type  Gambar',
            'ISI_GAMBAR' => 'Isi  Gambar',
            'CREATE_AT' => 'Create  At',
            'CREATE_BY' => 'Create  By',
            'UPDATE_AT' => 'Update  At',
            'UPDATE_BY' => 'Update  By',
            'STATUS' => 'Status',
        ];
    }
}
