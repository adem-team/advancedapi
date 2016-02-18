<?php

namespace backend\models;

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
    public static function tableName()
    {
        return 'provinsi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province_id'], 'required'],
            [['province_id'], 'integer'],
            [['province'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'province_id' => 'Province ID',
            'province' => 'Province',
        ];
    }

    /**
     * @inheritdoc
     * @return ProvinsiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProvinsiQuery(get_called_class());
    }
}
