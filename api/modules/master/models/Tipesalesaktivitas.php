<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "so_t2type".
 *
 * @property string $ID
 * @property string $SO_TYPE
 * @property string $UNTUK_DEVICE
 * @property integer $STATUS
 * @property string $CREATE_AT
 * @property integer $CREATE_BY
 * @property string $UPDATE_AT
 * @property integer $UPDATE_BY
 * @property integer $SO_ID
 */
class Tipesalesaktivitas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'so_t2type';
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
            [['STATUS', 'CREATE_BY', 'UPDATE_BY', 'SO_ID'], 'integer'],
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['SO_TYPE', 'UNTUK_DEVICE','SCOPE_BARANG'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'SO_TYPE' => 'So  Type',
            'UNTUK_DEVICE' => 'Untuk  Device',
            'STATUS' => 'Status',
            'CREATE_AT' => 'Create  At',
            'CREATE_BY' => 'Create  By',
            'UPDATE_AT' => 'Update  At',
            'UPDATE_BY' => 'Update  By',
            'SO_ID' => 'So  ID',
            'SCOPE_BARANG' => 'Scope Barang',
        ];
    }
}
