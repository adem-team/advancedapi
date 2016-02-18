<?php

namespace api\modules\gsn\models;

use Yii;

/**
 * This is the model class for table "kota".
 *
 * @property integer $city_id
 * @property integer $province_id
 * @property string $province
 * @property string $type
 * @property string $city_name
 * @property integer $postal_code
 */
class Kota extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public static function getDb()
    {
        /* Author -ptr.nov- :UMUM */
        return \Yii::$app->db;
    }
	
    public static function tableName()
    {
        return 'kota';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id'], 'required'],
            [['city_id', 'province_id', 'postal_code'], 'integer'],
            [['province', 'city_name'], 'string', 'max' => 200],
            [['type'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'city_id' => 'City ID',
            'province_id' => 'Province ID',
            'province' => 'Province',
            'type' => 'Type',
            'city_name' => 'City Name',
            'postal_code' => 'Postal Code',
        ];
    }

    /**
     * @inheritdoc
     * @return KotaQuery the active query used by this AR class.
     */
   /* public static function find()
    {
        return new KotaQuery(get_called_class());
    }
	*/
}
