<?php

namespace api\modules\eventmaxi\models;

use Yii;

/**
 * This is the model class for table "p0001".
 *
 * @property integer $ID
 * @property string $KD_PRODUCT
 * @property string $NM_PRODUCT
 * @property string $CREATE_AT
 * @property integer $CREATE_BY
 * @property string $UPDATE_AT
 * @property integer $UPDATE_BY
 * @property integer $STATUS
 */
class Productevent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p0001';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbevent');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_PRODUCT', 'NM_PRODUCT', 'CREATE_AT', 'CREATE_BY', 'UPDATE_AT', 'UPDATE_BY'], 'required'],
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['CREATE_BY', 'UPDATE_BY', 'STATUS'], 'integer'],
            [['KD_PRODUCT', 'NM_PRODUCT'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_PRODUCT' => 'Kd  Product',
            'NM_PRODUCT' => 'Nm  Product',
            'CREATE_AT' => 'Create  At',
            'CREATE_BY' => 'Create  By',
            'UPDATE_AT' => 'Update  At',
            'UPDATE_BY' => 'Update  By',
            'STATUS' => 'Status',
        ];
    }
}
