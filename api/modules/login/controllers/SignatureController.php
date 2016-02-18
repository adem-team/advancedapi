<?php

namespace api\modules\login\controllers;

use yii;
use kartik\datecontrol\Module;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\User;
use api\modules\login\models\Userlogin;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
//use yii\data\ActiveDataProvider;

/**
  * Controller Pilotproject Class  
  *
  * @author ptrnov  <piter@lukison.com>
  * @since 1.1
  * @link https://github.com/C12D/advanced/blob/master/api/modules/chart/controllers/PilotpController.php
  * @see https://github.com/C12D/advanced/blob/master/api/modules/chart/controllers/PilotpController.php
 */
class SignatureController extends ActiveController
{	
	/**
	  * Source Database declaration 
	 */
    public $modelClass = 'api\modules\login\models\Employe';
	//public $serializer = [
	//	'class' => 'yii\rest\Serializer',
	//	'collectionEnvelope' => 'Personalia',
	//];
	
	/**
     * @inheritdoc
     */
    public function behaviors()    {
        return ArrayHelper::merge(parent::behaviors(), [
            //'authenticator' => [
                //'class' => CompositeAuth::className(),
                //'authMethods' => [
                 //['class' => HttpBearerAuth::className()],
                 //['class' => QueryParamAuth::className()],//, 'tokenParam' => 'access-token'],
                //]
            //],
			'bootstrap'=> [
				'class' => ContentNegotiator::className(),
				'formats' => [
					'application/json' => Response::FORMAT_JSON,'charset' => 'UTF-8',
				],
				'languages' => [
					'en',
					'de',
				],
			],			
			'corsFilter' => [
				'class' => \yii\filters\Cors::className(),
				'cors' => [
					// restrict access to
					//'Origin' => ['http://lukisongroup.com', 'http://lukisongroup.int','http://localhost','http://103.19.111.1','http://202.53.354.82'],
					'Origin' => ['*'],
					'Access-Control-Request-Method' => ['POST', 'PUT','GET'],
					// Allow only POST and PUT methods
					'Access-Control-Request-Headers' => ['X-Wsse'],
					// Allow only headers 'X-Wsse'
					'Access-Control-Allow-Credentials' => true,
					// Allow OPTIONS caching
					'Access-Control-Max-Age' => 3600,
					// Allow the X-Pagination-Current-Page header to be exposed to the browser.
					'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
				]		
			],
        ]);
		
    }
	
	/**
     * @inheritdoc
     */
	public function actions()
	 {
		 $actions = parent::actions();
		unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		 //unset($actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		 return $actions;
	 }
	 
	/**
     * Get Request Status 
	 * @type GET
     */
	protected function getEmpSignature(){
		$request = Yii::$app->request;
		$profile=Yii::$app->getUserOpt->Profile_user_one($request->get("id"));		
		if (count($profile)!=0){			 		
			 //return $this->parseString($profile->emp->SIGNATURE);
			 return $profile->emp->SIGNATURE;
		}else{
			return "false";
		}	 
	} 
	
	 protected function getEmpName(){
		$request = Yii::$app->request;
		$profile=Yii::$app->getUserOpt->Profile_user_one($request->get("id"));		
		if (count($profile)!=0){			 		
			 return $profile->emp->EMP_NM .' '. $profile->emp->EMP_NM_BLK;
		}else{
			return "false";
		}	 
	}  	
	
	protected function SignatureCheck(){
		 $hasil=$this->getEmpSignature();
		//"name":"'. $this->getEmpName() .'",
		return Json::decode($hasil);
	}
	
	/**
	  * getUrl: http://api.lukisongroup.int/chart/pilotps?access-token=azLSTAYr7Y7TLsEAML-LsVq9cAXLyAWa&id_user=1&pilih=1
	  * id_user=1 [user id login]
	  * pilih=1 [0=department;1=user aktif]
	  * @link http://api.lukisongroup.int/chart/pilotps?access-token=azLSTAYr7Y7TLsEAML-LsVq9cAXLyAWa&id_user=1&pilih=1
	*/
	public function actionIndex()
     {
	
		return $this->SignatureCheck();	
     }
	
	 
	protected function parseString($string) {
           
		    $string = str_replace("\\", "", $string);
            $string = str_replace('/', "", $string);
           // $string = str_replace('"', "", $string);
            $string = str_replace("\b", "", $string);
            $string = str_replace("\t", "", $string);
            $string = str_replace("\n","", $string);
            $string = str_replace("\f", "", $string);
            $string = str_replace("\r", "", $string);
            $string = str_replace("\u", "", $string);
			
			$string = str_replace("\\\\","", $string);
            $string = str_replace("\\/","", $string);
            $string = str_replace("\\".'"',"", $string);
            $string = str_replace("\\b","", $string);
            $string = str_replace("\\t","", $string);
            $string = str_replace( "\\n","", $string);
            $string = str_replace("\\f","", $string);
            $string = str_replace("\\r","", $string);
            $string = str_replace("\\u","", $string); 
		
    	    return $string;
    }
}


