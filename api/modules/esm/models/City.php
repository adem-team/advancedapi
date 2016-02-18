<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;
/**
 *
 * @author -ptr.nov- 
 */
class City extends ActiveRecord 
{
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
