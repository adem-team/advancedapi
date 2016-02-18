<?php
namespace api\modules\esm\models;
use \yii\db\ActiveRecord;
/**
 *
 * @author -ptr.nov- 
 */
class Kabupaten extends ActiveRecord 
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
		return 'a0002';
	}

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['CITY_ID'];
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['CITY_ID','PROVINCE_ID'], 'required']
        ];
    }
 
}
