<?php

namespace api\modules\chart\models;

use Yii;

/**
 * This is the model class for table "c0014".
 *
 * @property integer $ID
 * @property integer $ID_DETAIL
 * @property string $KD_CUSTOMER
 * @property string $NM_CUSTOMER
 * @property integer $ID_USER
 * @property string $NM_USER
 * @property string $ISI_MESSAGES
 * @property string $TGL
 * @property integer $STATUS
 * @property integer $CREATE_BY
 * @property string $CREATE_AT
 * @property integer $UPDATE_BY
 * @property string $UPDATE_AT
 */
class Esmsalesmdmemo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0014';
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
            [['ID_DETAIL', 'ID_USER', 'STATUS', 'CREATE_BY', 'UPDATE_BY'], 'integer'],
            [['ISI_MESSAGES'], 'string'],
            [['TGL', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['KD_CUSTOMER', 'NM_CUSTOMER', 'NM_USER'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ID_DETAIL' => 'Id  Detail',
            'KD_CUSTOMER' => 'Kd  Customer',
            'NM_CUSTOMER' => 'Nm  Customer',
            'ID_USER' => 'Id  User',
            'NM_USER' => 'Nm  User',
            'ISI_MESSAGES' => 'Isi  Messages',
            'TGL' => 'Tgl',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
