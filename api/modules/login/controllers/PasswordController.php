<?php

namespace api\modules\login\controllers;

use yii;
use kartik\datecontrol\Module;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\User;
use api\modules\login\models\Userlogin;
use yii\base\Model;
use yii\web\IdentityInterface;
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
class PasswordController extends ActiveController
{
	/**
	  * Source Database declaration
	 */
    public $modelClass = 'api\modules\login\models\Userlogin';
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
					'Access-Control-Allow-Headers' => ['X-Requested-With','content-type'],
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
	protected function get_status(){
		$request = Yii::$app->request;
		$models=Userlogin::find()->where("id='".$request->get("id")."' and auth_key='".$request->get("token")."'")->one();
		if (count($models)!=0){
			if (Yii::$app->security->validatePassword($request->get("password"), $models->password_hash)){
				return "true";
			}else{
				return "false";
			}
		}else{
			return "false";
		}
	}

	/**
     * Get Request token
	 * @type GET
     */
	protected function get_tokenp(){
		$request = Yii::$app->request;
		 $models=Userlogin::find()->where("id='".$request->get("id")."' and auth_key='".$request->get("token")."'")->one();
		if (count($models)!=0){
			return $models->auth_key;
		}else{
			return "none";
		}
	}

	protected function get_userid(){
		$request = Yii::$app->request;
		 $models=Userlogin::find()->where("id='".$request->get("id")."' and auth_key='".$request->get("token")."'")->one();
		if (count($models)!=0){
			return $models->id;
		}else{
			return "none";
		}
	}

	protected function get_usernm(){
		$request = Yii::$app->request;
		 $models=Userlogin::find()->where("id='".$request->get("id")."' and auth_key='".$request->get("token")."'")->one();
		if (count($models)!=0){
			return $models->username;
		}else{
			return "none";
		}
	}

	protected function get_ruleid(){
		$request = Yii::$app->request;
		$models=Userlogin::find()->where("id='".$request->get("id")."' and auth_key='".$request->get("token")."'")->one();
		if (count($models)!=0){
			return $models->POSITION_LOGIN;
		}else{
			return "none";
		}
	}

	/*ACCESS*/
	protected function get_accessid(){
		$request = Yii::$app->request;
		$models=Userlogin::find()->where("id='".$request->get("id")."' and auth_key='".$request->get("token")."'")->one();
		if (count($models)!=0){
			return $models->POSITION_ACCESS;
		}else{
			return "none";
		}
	}
	protected function get_uuid(){
		$request = Yii::$app->request;
		$models=Userlogin::find()->where("id='".$request->get("id")."' and auth_key='".$request->get("token")."'")->one();
		if (count($models)!=0){
			return $models->UUID;
		}else{
			return "none";
		}
	}
	protected function get_rulenm(){
		$request = Yii::$app->request;
		$models=Userlogin::find()->where("id='".$request->get("id")."' and auth_key='".$request->get("token")."'")->one();
		if (count($models)!=0){
			if ($models->POSITION_LOGIN==1){
				return 'SALESMAN';
			}elseif($models->POSITION_LOGIN==2){
				return 'SALES_PROMOTION';
			}elseif($models->POSITION_LOGIN==3){
				return 'CUSTOMER';
			}elseif($models->POSITION_LOGIN==4){
				return 'DISTRIBUTOR';
			}elseif($models->POSITION_LOGIN==5){
				return 'FACTORY_PABRIK';
			}elseif($models->POSITION_LOGIN==6){
				return 'OUTSOURCE';
			}elseif($models->POSITION_LOGIN==7){
				return 'MANAGER';
			}else{
				return 'none';
			}

		}else{
			return "none";
		}
	}

	protected function passwordCheck(){
		 $hasil='{
			"passwordvalidation":
					{
						"login":"'. $this->get_status() .'",
						"id":"'. $this->get_userid() .'",
						"username":"'. $this->get_usernm() .'",
						"rule_id":"'. $this->get_ruleid() .'",
						"rule_nm":"'. $this->get_rulenm() .'",
						"token":"'. $this->get_tokenp() .'",
						"accessid":"'. $this->get_accessid() .'",
						"uuid":"'. $this->get_uuid() .'"
					}

		 }';

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
		/*  $hasil='{'
			.$this->userCheck().
		'}';

		 $json_pilot = Json::decode($hasil); */
		return $this->passwordCheck();

     }

	 /*
	 public function actionCreate()
     {
         $model = new $this->modelClass();
         // $model->load(Yii::$app->getRequest()
         // ->getBodyParams(), '');
         $model->attributes = Yii::$app->request->post();
         if (! $model->save()) {
             return ($model->getFirstErrors())[0];
         }
         return $model;
     }
	 */
	 /*
	 public function actionView($id)
     {
         return $this->findModel($id);
     }

	 protected function findModel($id)
     {
         $modelClass = $this->modelClass;
         if (($model = $modelClass::findOne($id)) !== null) {
             return $model;
         } else {
            // throw new NotFoundHttpException('The requested page does not exist.');
			echo 'Data Tidak Temukan, coba data yang lain !  helpdesk : helpdesk@lukison.com';
         }
	}
	*/

}


