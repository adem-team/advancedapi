<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;

/**
 * This is the model class for table "Item_group".
 *
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 * @property integer $STATUS
 * @property integer $ITEM_GRP_ID
 * @property integer $LOCATE
 * @property string $LOCATE_DCRP
 * @property integer $LOCATE_SUB
 * @property string $LOCATE_SUB_DCRP
 * @property integer $OUTLET_ID
 * @property string $OUTLET_NM
 * @property string $OUTLET_BARCODE
 * @property integer $ITEM_ID
 * @property string $ITEM_NM
 * @property string $ITEM_BARCODE
 * @property string $PERSEN_MARGIN
 */
class ItemGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Item_group';
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
            [['CREATE_AT', 'UPDATE_AT', 'OUTLET_ID'], 'safe'],
            [['STATUS', 'LOCATE', 'LOCATE_SUB'], 'integer'],
            [['PERSEN_MARGIN'], 'number'],
            [['CREATE_BY', 'UPDATE_BY','ITEM_ID'], 'string', 'max' => 50],
            [['ITEM_BARCODE','GRP_DISPLAY','FORMULA_ID'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CREATE_BY' => Yii::t('app', 'Create.By'),
            'CREATE_AT' => Yii::t('app', 'Create.At'),
            'UPDATE_BY' => Yii::t('app', 'Update.By'),
            'UPDATE_AT' => Yii::t('app', 'Update.At'),
            'STATUS' => Yii::t('app', 'Status'),            
            'LOCATE' => Yii::t('app', 'Locate'),
            'LOCATE_SUB' => Yii::t('app', 'Locate  Sub'),			
            'OUTLET_ID' => Yii::t('app', 'Outlet  ID'), 				//join store
            'ITEM_ID' => Yii::t('app', 'Item  ID'),						//join items
            'ITEM_BARCODE' => Yii::t('app', 'Item.Barcode'), 			//generate, kombinasi Kode.
            'PERSEN_MARGIN' => Yii::t('app', 'Margin'),
            'ItemNm' => Yii::t('app', 'Item.Name'),
            'HPP' => Yii::t('app', 'HPP'),
			//Attribute Join.
            'StoreNm' => Yii::t('app', 'OUTLET NAME'),
            'LocateNm' => Yii::t('app', 'LOCATE'),
            'LocatesubNm' => Yii::t('app', 'LOCATE-SUB'),
            'GRP_DISPLAY' => Yii::t('app', 'GRP_DISPLAY'),
            'FORMULA_ID' => Yii::t('app', 'FORMULA.DISCOUNT'),
        ];
    }
	
	public function fields()
	{
		return [
			'OUTLET_ID'=>function($model){
							return $model->OUTLET_ID;
			},
			'StoreNm'=>function(){
							return $this->storeNm;
			},
			'LocateNm'=>function(){
							return $this->LocateNm;
			},	
			'LocatesubNm'=>function(){
							return $this->LocatesubNm;
			},	
			'ITEM_BARCODE'=>function($model){
							return $model->ITEM_BARCODE;
			},	
			'ItemNm'=>function(){
							return $this->ItemNm;
			},	
			'GRP_DISPLAY'=>function($model){
							return $model->GRP_DISPLAY;
			},	
			'HPP'=>function(){
							return $this->HPP;
			},	
			'PERSEN_MARGIN'=>function(){
							return $this->PERSEN_MARGIN;
			},
			'FORMULA_ID'=>function(){
							return $this->FORMULA_ID;
			},	
			'STATUS'=>function($model){
							return $model->STATUS;
			},	
			'CREATE_AT'=>function(){
							return $this->CREATE_AT;
			},	
			'UPDATE_AT'=>function(){
							return $this->UPDATE_AT;
			},
			'CREATE_BY'=>function(){
							return $this->CREATE_BY;
			},	
			'UPDATE_BY'=>function(){
							return $this->UPDATE_BY;
			},	
		
		];
	}
	
	/* public static function primaryKey()
    {
      return ['OUTLET_ID','ITEM_BARCODE'];
    } */
	
	//JOIN TABLE ITEM
	public function getItemTbl()
	{
		return $this->hasOne(Item::className(), ['ITEM_ID' => 'ITEM_ID'])->from(['item' => Item::tableName()]);
	}	
	//JOIN TABLE STORE
	public function getStoreTbl()
    {
        return $this->hasOne(Store::className(), ['OUTLET_BARCODE' => 'OUTLET_ID']);
	}
	
	//JOIN TABLE LOCATE VIA STORE
	public function getLocateTbl()
	{
		//return $this->hasOne(Locate::className(), ['ID' => 'LOCATE'])->from(['locate' => Locate::tableName()])->via('storeTbl');
		return $this->hasOne(Locate::className(), ['ID' => 'LOCATE'])->via('storeTbl');
		//return $this->hasOne(Store::className(), ['EMP_ID' => 'OUTLET_ID'])->via('userTbl');
	}
	//JOIN TABLE LOCATE SUB VIA STORE
	public function getLocatesubTbl()
	{
		//return $this->hasOne(Locate::className(), ['ID' => 'LOCATE'])->from(['locate' => Locate::tableName()])->via('storeTbl');
		return $this->hasOne(Locate::className(), ['ID' => 'LOCATE_SUB'])->via('storeTbl');
		//return $this->hasOne(Store::className(), ['EMP_ID' => 'OUTLET_ID'])->via('userTbl');
	}
	
	//Attribute ITEM - ITEM_NM
	public function getItemNm()
	{
		return $this->itemTbl->ITEM_NM;
	}	
	//Attribute ITEM - IMAGE
	public function getGambar()
	{
		$gmb= $this->itemTbl->IMG64;
		$noGmb= $this->itemTbl->Noimage;
		return $gmb!=''?'data:image/jpg;charset=utf-8;base64,'.$gmb:'data:image/jpg;charset=utf-8;base64,'.$noGmb;
	}
	
	//Attribute STORE - OUTLET_NM
	public function getStoreNm()
	{
		return $this->storeTbl->OUTLET_NM;
	}	
	
	//Attribute LOCATE VIA STORE, [LOCATE_NAME]
	public function getLocateNm()
	{
		return $this->locateTbl->LOCATE_NAME;
	}
	
	//Attribute LOCATE SUB VIA STORE, [LOCATE_NAME]
	public function getLocatesubNm()
	{
		return $this->locatesubTbl->LOCATE_NAME;
	}	
	
}
