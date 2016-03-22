<?php
namespace api\modules\esm\models;
use \yii\db\ActiveRecord;
/**
 *
 * @author -ptr.nov- 
 */
class Provinsi extends ActiveRecord 
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
		return 'a0001';
	}

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['PROVINCE_ID'];
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['PROVINCE_ID', 'PROVINCE'], 'required']
        ];
    }
 
}
