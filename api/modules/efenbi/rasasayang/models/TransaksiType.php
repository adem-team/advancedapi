<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;

/**
 * This is the model class for table "transaksi_type".
 *
 * @property integer $ID
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 * @property integer $STATUS
 * @property string $CODE_TRANS
 * @property string $TYPE_NM
 */
class TransaksiType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaksi_type';
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
            [['CREATE_AT', 'UPDATE_AT','TYPE_DCRIP'], 'safe'],
            [['STATUS','TRANS_TYPE'], 'integer'],
            [['CREATE_BY', 'UPDATE_BY', 'CODE_TRANS', 'TYPE_NM'], 'string', 'max' => 50],
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
			'TYPE_NM' => Yii::t('app', 'TYPE'),
            'CODE_TRANS' => Yii::t('app', 'REF-CODE.TRANS'),      
            'TYPE_DCRIP' => Yii::t('app', 'DISCRIPTION'),
        ];
    }
}
