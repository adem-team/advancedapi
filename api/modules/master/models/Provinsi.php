<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "provinsi".
 *
 * @property integer $province_id
 * @property string $province
 */
class Provinsi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public static function getDb()
    {
        /* Author -ptr.nov- :UMUM */
        return \Yii::$app->db_gsn;
    }
    public static function tableName()
    {
        return 'a0001';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PROVINCE_ID'], 'required'],
            [['PROVINCE_ID'], 'integer'],
            [['PROVINCE'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PROVINCE_ID' => 'Province ID',
            'PROVINCE' => 'Province',
        ];
    }

    /**
     * @inheritdoc
     * @return ProvinsiQuery the active query used by this AR class.
     */
   /* public static function find()
    {
        return new ProvinsiQuery(get_called_class());
    }
*/
}
