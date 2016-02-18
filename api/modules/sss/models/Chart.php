<?php
namespace api\modules\sss\models;
 use yii\web\IdentityInterface;
use \yii\db\ActiveRecord;
/**
 * Country Model
 *
 * @author -ptr.nov-
 */
class Chart extends ActiveRecord implements IdentityInterface
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
	 
	public static function getDb()
    {
        /* Author -ptr.nov- :UMUM */
        return \Yii::$app->db_sssChart;
    }
	
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		//return '{{country}}';
		return 'Tab_Val';
	}
  
  
   public function fields()
	{
		return [
			'Id',
			'Val_Nm','Val_1','UPDT','Val_Json',
		];	
	}
	
    public function rules()
    {
        return [
            [['Id'], 'required'],
            [['Id'], 'integer'],
            [['Val_Nm'], 'string', 'max' => 100],
            [['Val_1'], 'integer'],
            [['UPDT'], 'date'],
            [['Val_Json'], 'string'],
        ];
    }   
}
