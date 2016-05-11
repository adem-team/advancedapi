<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c0011".
 *
 * @property integer $ID
 * @property string $PRIORITAS_EXPIRED
 * @property integer $STATUS
 * @property string $CREATE_AT
 * @property string $UPDATE_AT
 * @property integer $CREATE_BY
 * @property integer $UPDATE_BY
 */
class Expiredprioritas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0011';
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
            [['STATUS', 'CREATE_BY', 'UPDATE_BY','JANGKA_WAKTU'], 'integer'],
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['PRIORITAS_EXPIRED'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PRIORITAS_EXPIRED' => 'Prioritas  Expired',
            'STATUS' => 'Status',
            'CREATE_AT' => 'Create  At',
            'UPDATE_AT' => 'Update  At',
            'CREATE_BY' => 'Create  By',
            'UPDATE_BY' => 'Update  By',
            'JANGKA_WAKTU' => 'Jangka Waktu'
        ];
    }
}
