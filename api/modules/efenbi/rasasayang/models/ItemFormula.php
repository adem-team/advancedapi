<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;

/**
 * This is the model class for table "Item_formula".
 *
 * @property integer $ID_DTL_FORMULA
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 * @property integer $STATUS
 * @property integer $TYPE
 * @property string $TYPE_NM
 * @property integer $ID_STORE
 * @property integer $ID_ITEM
 * @property string $DISCOUNT_PESEN
 * @property string $DISCOUNT_WAKTU
 * @property integer $DISCOUNT_HARI
 */
class ItemFormula extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Item_formula';
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
			[['CREATE_AT', 'UPDATE_AT','FORMULA_DCRIP','FORMULA_NM'], 'safe'],
			[['STATUS'], 'integer'],
			[['CREATE_BY', 'UPDATE_BY','FORMULA_ID',], 'string', 'max' => 50]
           /*  [['CREATE_AT', 'UPDATE_AT', 'DISCOUNT_WAKTU1','DISCOUNT_WAKTU2','DISCOUNT_VALUE'], 'safe'],
            [['STATUS','DISCOUNT_QTY'], 'integer'],
            //[['DISCOUNT_VALUE'], 'number'],
            [['CREATE_BY', 'UPDATE_BY','FORMULA_ID','OUTLET_BARCODE','DISCOUNT_HARI'], 'string', 'max' => 50], */
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
            'FORMULA_ID' => Yii::t('app', 'FORMULA_ID'),
            'FORMULA_DCRIP' => Yii::t('app', 'DISCRIPTION'),
            'FORMULA_NM' => Yii::t('app', 'NAME')
        ];
    }
	
	public function fields()
	{
		return [
			'FORMULA_ID'=>function($model){
				return $model->FORMULA_ID;
			},
			'FORMULA_NM'=>function($model){
				return $model->FORMULA_NM;
			},
			'FORMULA_DCRIP'=>function($model){
				return $model->FORMULA_DCRIP;
			}			
		];
	}
	
	//JOIN FORMULA HEADER.
	// public function getFormulaHeaderTbl()
	// {
		// return $this->hasOne(ItemFormula::className(), ['FORMULA_ID' => 'FORMULA_ID']);
	// }	
		
	//JOIN FORMULA DETAIL VIA FORMULA HEADER.
	// public function getFormulaDetailTbl()
	// {
		// return $this->hasMany(ItemFormulaDetail::className(), ['PARENT_ID' => 'ID']);
	// }
	// public function getDetailDiscountHari()
	// {
		// return  $this->formulaDetailTbl->DISCOUNT_HARI;
	// }
	
	
}
