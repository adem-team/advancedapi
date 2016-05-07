<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c0012".
 *
 * @property integer $ID
 * @property integer $ID_PRIORITASED
 * @property integer $ID_DETAIL
 * @property string $CUST_ID
 * @property string $BRG_ID
 * @property integer $USER_ID
 * @property string $TGL_KJG
 * @property integer $QTY
 * @property string $DATE_EXPIRED
 * @property integer $STATUS
 * @property string $CREATE_AT
 * @property string $UPDATE_AT
 * @property integer $CREATE_BY
 * @property integer $UPDATE_BY
 */
class Expiredproduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0012';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db3');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_PRIORITASED', 'ID_DETAIL', 'CUST_ID', 'BRG_ID', 'USER_ID', 'TGL_KJG', 'QTY', 'DATE_EXPIRED'], 'required'],
            [['ID_PRIORITASED', 'ID_DETAIL', 'USER_ID', 'QTY', 'STATUS', 'CREATE_BY', 'UPDATE_BY'], 'integer'],
            [['TGL_KJG', 'DATE_EXPIRED', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['CUST_ID', 'BRG_ID'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ID_PRIORITASED' => 'Id  Prioritased',
            'ID_DETAIL' => 'Id  Detail',
            'CUST_ID' => 'Cust  ID',
            'BRG_ID' => 'Brg  ID',
            'USER_ID' => 'User  ID',
            'TGL_KJG' => 'Tgl  Kjg',
            'QTY' => 'Qty',
            'DATE_EXPIRED' => 'Date  Expired',
            'STATUS' => 'Status',
            'CREATE_AT' => 'Create  At',
            'UPDATE_AT' => 'Update  At',
            'CREATE_BY' => 'Create  By',
            'UPDATE_BY' => 'Update  By',
        ];
    }
}
