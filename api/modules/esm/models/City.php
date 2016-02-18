<?php
namespace api\modules\esm\models;
use \yii\db\ActiveRecord;
/**
 *
 * @author -ptr.nov- 
 */
class City extends ActiveRecord 
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
		return 'city';
	}

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['code'];
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['code', 'name', 'population'], 'required']
        ];
    }   
}
