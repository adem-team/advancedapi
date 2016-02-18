<?php
namespace api\modules\notify\models;
 use yii\web\IdentityInterface;
use \yii\db\ActiveRecord;
/**
 * Country Model
 *
 * @author -ptr.nov-
 */
class Hrd_persona extends ActiveRecord implements IdentityInterface
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
        return \Yii::$app->db_notify;
    }
	
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		//return '{{country}}';
		return 'a0001';
	}
	
    /**
     * @inheritdoc
     */

  //  public static function primaryKey()
   // {
    //   return ['NOTIFY_ID'];
   // }
   
   
   
   public function fields()
	{
		return [
			'NOTIFY_ID',
			'NOTIFY_NM','NOTIFY_JSON',
		];	
	}
    public function rules()
    {
        return [
      //      [['NOTIFY_ID', 'NOTIFY_NM', 'NOTIFY_JSON'], 'required']
	       [['NOTIFY_ID'], 'required'],
            [['NOTIFY_ID'], 'integer'],
            [['NOTIFY_NM'], 'string', 'max' => 50],
            [['NOTIFY_JSON'], 'integer'],
        ];
    }   
}
