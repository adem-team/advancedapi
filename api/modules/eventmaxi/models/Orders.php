<?php

namespace api\modules\eventmaxi\models;

use Yii;

/**
 * This is the model class for table "o0001".
 *
 * @property integer $ID
 * @property string $NO_RESIORDER
 * @property string $TGL_ORDER
 * @property string $CUST_KD
 * @property string $CUST_NM
 * @property string $KD_EVENT
 * @property string $NM_EVENT
 * @property integer $TOTAL_ORDER
 * @property string $STATUS_ORDER
 * @property string $CREATE_AT
 * @property integer $CREATE_BY
 * @property string $UPDATE_AT
 * @property integer $UPDATE_BY
 * @property integer $STATUS
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o0001';
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
            [['NO_RESIORDER', 'TGL_ORDER', 'CUST_KD', 'CUST_NM', 'KD_EVENT', 'NM_EVENT', 'TOTAL_ORDER', 'STATUS_ORDER', 'CREATE_AT', 'CREATE_BY', 'UPDATE_AT', 'UPDATE_BY'], 'required'],
            [['TGL_ORDER', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['TOTAL_ORDER', 'CREATE_BY', 'UPDATE_BY', 'STATUS'], 'integer'],
            [['NO_RESIORDER', 'CUST_KD', 'CUST_NM'], 'string', 'max' => 100],
            [['KD_EVENT', 'NM_EVENT', 'STATUS_ORDER'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NO_RESIORDER' => 'No  Resiorder',
            'TGL_ORDER' => 'Tgl  Order',
            'CUST_KD' => 'Cust  Kd',
            'CUST_NM' => 'Cust  Nm',
            'KD_EVENT' => 'Kd  Event',
            'NM_EVENT' => 'Nm  Event',
            'TOTAL_ORDER' => 'Total  Order',
            'STATUS_ORDER' => 'Status  Order',
            'CREATE_AT' => 'Create  At',
            'CREATE_BY' => 'Create  By',
            'UPDATE_AT' => 'Update  At',
            'UPDATE_BY' => 'Update  By',
            'STATUS' => 'Status',
        ];
    }
}
