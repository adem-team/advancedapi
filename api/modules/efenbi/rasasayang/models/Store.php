<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;

/**
 * This is the model class for table "store".
 *
 * @property integer $ID
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 * @property integer $STATUS
 * @property integer $LOCATE
 * @property string $LOCATE_SUB
 * @property string $OUTLET_BARCODE
 * @property string $OUTLET_NM
 * @property string $ALAMAT
 * @property string $PIC
 * @property string $TLP
 */
class Store extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'store';
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
            [['STATUS','LOCATE_SUB', 'LOCATE'], 'integer'],
            [['ALAMAT'], 'string'],
            [['CREATE_BY', 'UPDATE_BY', 'OUTLET_BARCODE', 'TLP'], 'string', 'max' => 50],
            [['OUTLET_NM', 'PIC'], 'string', 'max' => 100],
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'CREATE_BY' => Yii::t('app', 'CREATE BY'),
            'CREATE_AT' => Yii::t('app', 'CREATE AT'),
            'UPDATE_BY' => Yii::t('app', 'UPDATE BY'),
            'UPDATE_AT' => Yii::t('app', 'UPDATE AT'),
            'STATUS' => Yii::t('app', 'STATUS'),
            'LOCATE' => Yii::t('app', 'CABANG'),
            'LOCATE_SUB' => Yii::t('app', 'SUB.CABANG '),
            'LocateNm' => Yii::t('app', 'CABANG'),
            'LocatesubNm' => Yii::t('app', 'SUB.CABANG '),
            'OUTLET_BARCODE' => Yii::t('app', 'BARCODE'),
            'OUTLET_NM' => Yii::t('app', 'OUTLET NAME'),
            'ALAMAT' => Yii::t('app', 'ALAMAT'),
            'PIC' => Yii::t('app', 'PIC'),
            'TLP' => Yii::t('app', 'PHONE'),
        ];
    }
	
	public function getLocateTbl()
	{
		return $this->hasOne(Locate::className(), ['ID' => 'LOCATE'])->from(['locate' => Locate::tableName()]);
	}
	public function getLocateNm()
	{
		return $this->locateTbl->LOCATE_NAME;
	}
	public function getLocatesubTbl()
	{
		return $this->hasOne(Locate::className(), ['ID' => 'LOCATE_SUB'])->from(['locatesub' => Locate::tableName()]);
	}
	public function getLocatesubNm()
	{
		return $this->locatesubTbl->LOCATE_NAME;
	}	
	
	public function fields()
	{
		return [
			'OUTLET_BARCODE'=>function($model){
				return $model->OUTLET_BARCODE;
			},
			'OUTLET_NM'=>function($model){
				return $model->OUTLET_NM;
			},
			'LOCATE'=>function($model){
				return $model->LOCATE;
			},	
			'LOCATE_NAME'=>function(){
				return $this->LocateNm;
			},		
			'LOCATE_SUB'=>function($model){
				return $model->LOCATE_SUB;
			},		
			'LOCATE_SUB_NAME'=>function(){
				return $this->LocatesubNm;
			},		
			'ALAMAT'=>function($model){
				return $model->ALAMAT;
			},		
			'PIC'=>function($model){
				return $model->PIC;
			},	
			'TLP'=>function($model){
				return $model->TLP;
			},
			'STATUS'=>function($model){
				return $model->STATUS;
			},
			'CREATE_BY'=>function($model){
				return $model->CREATE_BY;
			},	
			'UPDATE_BY'=>function($model){
				return $model->UPDATE_BY;
			},		
			'CREATE_AT'=>function($model){
				return $model->CREATE_AT;
			},		
			'UPDATE_AT'=>function($model){
				return $model->UPDATE_AT;
			},		
		
		];
	}
}
