<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;

/**
 * This is the model class for table "transaksi_header".
 *
 * @property integer $ID
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 * @property integer $STATUS
 * @property string $TRANS_DATE
 * @property string $OUTLET_ID
 * @property integer $TRANS_TYPE
 * @property string $TRANS_ID
 */
class TransaksiHeader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaksi_header';
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
            [['CREATE_AT', 'UPDATE_AT', 'TRANS_DATE'], 'safe'],
            [['STATUS', 'TRANS_TYPE'], 'integer'],
            [['CREATE_BY', 'UPDATE_BY', 'OUTLET_ID'], 'string', 'max' => 50],
            [['TRANS_ID'], 'string', 'max' => 100],
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
            'STATUS' => Yii::t('app', 'Status'),
            'TRANS_DATE' => Yii::t('app', 'Trans  Date'),
            'OUTLET_ID' => Yii::t('app', 'Store  ID'),
            'TRANS_TYPE' => Yii::t('app', 'Trans  Type'),
            'TRANS_ID' => Yii::t('app', 'Trans  ID'),
        ];
    }
	
	//Join TABLE FORMULA
	public function getDetail(){
		return $this->hasMany(Transaksi::className(), ['TRANS_ID' => 'TRANS_ID']);
	}
	
	public function extraFields()
	{
		return ['detail'];
		//return ['unit'];
	}
}
