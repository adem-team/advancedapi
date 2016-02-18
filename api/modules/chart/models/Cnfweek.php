<?php

namespace api\modules\chart\models;
use Yii;

/*LABEL WEEK*/
class Cnfweek extends \yii\db\ActiveRecord
{
   public static function findIdentityByAccessToken($token, $type = null)
     {
         return static::findOne([
             'access_token' => $token
         ]);
     }
 
     public function getId()
     {
         return $this->id;
     }
 
     public function getAuthKey()
     {
         return $this->authKey;
     }
 
     public function validateAuthKey($authKey)
     {
         return $this->authKey === $authKey;
     }
 
     public static function findIdentity($id)
     {
         return static::findOne($id);
     }
	 
    public static function tableName()
    {
        return 'cnfweek';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_widget');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label', 'start', 'end', 'bulan', 'tahun'], 'required'],
            [['label',], 'string'],
            [['start', 'end','TITLE1'], 'date'],
            [['bulan', 'tahun'], 'integer']
        ];
    }

    public function fields()
	{
		return [
			'start'=>function($model){
							return Yii::$app->ambilKonvesi->convert($model->start,'date');
					},			
			'end'=>function($model){
							return Yii::$app->ambilKonvesi->convert($model->end,'date');
					},	
			'label',
		];
	}
	
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            //'label' => 'Labelxxss',
            'start' => 'Start s',
            'end' => 'End',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
			 'label' =>Yii::t('app', 'LABEL'),
        ];
    }
	
	
}
