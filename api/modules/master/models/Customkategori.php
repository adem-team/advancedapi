<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c0001k".
 *
 * @property string $CUST_KTG
 * @property string $CUST_KTG_PARENT
 * @property string $CUST_KTG_NM
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_BY
 * @property string $UPDATED_AT
 * @property integer $STATUS
 */
class Customkategori extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0001k';
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
            [['CUST_KTG_PARENT', 'STATUS'], 'integer'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['CUST_KTG_NM'], 'string', 'max' => 255],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CUST_KTG' => 'Cust  Ktg',
            'CUST_KTG_PARENT' => 'Cust  Ktg  Parent',
            'CUST_KTG_NM' => 'Cust  Ktg  Nm',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_AT' => 'Updated  At',
            'STATUS' => 'Status',
        ];
    }
    
    public static function primaryKey()
    {
      return ['CUST_KTG'];
    }
    public function getParents()
    {
        return $this->hasOne(Customkategori::className(), ['CUST_KTG_PARENT' => 'CUST_KTG_PARENT']);
    }
    public function extraFields()
    {
        return ['parents'];
        //return ['unit'];
    }
}
