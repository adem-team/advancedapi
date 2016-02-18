<?php
namespace api\modules\esm\models;
use \yii\db\ActiveRecord;
/**
 * Country Model
 *
 * @author -ptr.nov-
 */
class Country extends ActiveRecord 
{

	public static function getDb()
    {
        /* Author -ptr.nov- :UMUM */
        return \Yii::$app->get('db_gsn');
    }
	
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		//return '{{country}}';
		return 'country';
	}

    /**
     * @inheritdoc
     */

    public static function primaryKey()
    {
       return ['code'];
    }
    public function fields()
	{
		return [
			'code','name','population'
		];	
	}
    public function rules()
    {
        return [
            [['code', 'name', 'population'], 'required']
        ];
    }   
}
