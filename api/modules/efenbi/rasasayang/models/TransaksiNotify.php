<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;

/**
 * This is the model class for table "transaksi_notify".
 *
 * @property integer $ID
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 * @property integer $STATUS
 * @property string $TRANS_ID
 * @property string $NOTIFY_DCRIP
 */
class TransaksiNotify extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaksi_notify';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_efenbi');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['STATUS'], 'integer'],
            [['NOTIFY_DCRIP'], 'string'],
            [['CREATE_BY', 'UPDATE_BY', 'TRANS_ID'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'CREATE_BY' => Yii::t('app', 'CREATE_BY'),
            'CREATE_AT' => Yii::t('app', 'CREATE_AT'),
            'UPDATE_BY' => Yii::t('app', 'UPDATE_BY'),
            'UPDATE_AT' => Yii::t('app', 'UPDATE_AT'),
            'STATUS' => Yii::t('app', 'STATUS'),
            'CODE_TRANS' => Yii::t('app', 'CODE_TRANS'),   
            'TRANS_ID' => Yii::t('app', 'Trans  ID'),
			'TRANS_TYPE' => Yii::t('app', 'TRANS_TYPE'),	
            'NOTIFY_DCRIP' => Yii::t('app', 'Notify  Dcrip'),
        ];
    }
}
