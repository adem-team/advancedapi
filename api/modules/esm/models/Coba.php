<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;
/**
 *
 * @author -ptr.nov- 
 */
class Coba extends ActiveRecord 
{

	/*
	public static function getDb()
    {
        // Author -ptr.nov- :UMUM 
        return \Yii::$app->db_gsn;
    }
	*/
	
	/* [2] TABLE SELECT */
    public static function tableName()
    {
        return 'a0001';
    }

	 public static function primaryKey()
    {
        return ['PROVINCE_ID'];
    }
	
	/* [3] RULE SCENARIO -> DetailView */
    public function rules()
    {
        return [
            [['PROVINCE_ID','PROVINCE'], 'required'],
           // [['PROVINCE_ID'], 'integer'],
            //[['PROVINCE'], 'string', 'max' => 50],
        ];
    }

}
