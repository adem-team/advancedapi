<?php

namespace api\modules\notify\controllers;

use yii;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\User;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use api\modules\notify\models\Gps_customer;
use api\modules\notify\models\DeptSearch;
use yii\web\HttpException;
//use yii\data\ActiveDataProvider;
/**
 * Hrd_persona Controller API
 *
 * @author -ptr.nov-
 */
class Gps_customerController extends ActiveController
{
    public $modelClass = 'api\modules\notify\models\Gps_customer';
	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'gps',
	];
	  
    public function behaviors()    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => CompositeAuth::className(),
                /* 'authMethods' => [
                  ['class' => HttpBearerAuth::className()],
                 ['class' => QueryParamAuth::className()],//, 'tokenParam' => 'access-token'],
                ]  */
            ],
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
                'Origin' =>['*'],//'Origin' => ['http://lukisongroup.com', 'http://lukisongroup.com'],
                'Access-Control-Request-Method' => ['POST', 'PUT','GET'],
                // Allow only POST and PUT methods
                'Access-Control-Request-Headers' => ['X-Wsse'],
                // Allow only headers 'X-Wsse'
                'Access-Control-Allow-Credentials' => true,
                // Allow OPTIONS caching
                'Access-Control-Max-Age' => 3600,
                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            ],

        ],
            //'exceptionFilter' => [
            //    'class' => ErrorToExceptionFilter::className()            
			//],
        ]);
		
    }
	public function beforeAction($action) { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action); 
    } 
	public function actions()
	 {
		 $actions = parent::actions();
		//unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		 unset($actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		 return $actions;
	 } 
	 
	/* public function actionIndex(){
		 $poHeaderVal = new Gps_customer;
		if($poHeaderVal->load(Yii::$app->request->post())){
			//if ($poHeaderVal->generatepo_saved()){
				$hsl = \Yii::$app->request->post();
				//$kdPo =$poHeaderVal->PO_RSLT
				$res = array('status' => false);
				return  $res;
				//echo "test";
			//}														
		}
		 
	 } */
	 
	 
	 
	/* public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    } */
	
	public function actionCreate()
	{		
		$poHeaderVal = new Gps_customer;
		if($poHeaderVal->load(Yii::$app->request->post())){
			//if ($poHeaderVal->generatepo_saved()){
				$hsl = \Yii::$app->request->post();
				$poHeaderVal->save();
				//$kdPo =$poHeaderVal->PO_RSLT
				$res = array('status' => false);
				return  $res;
				//echo "test";
			//}														
		}
	}
 
      /* //$params=$_REQUEST;
	  $request = Yii::$app->request;
     // $request->get('id_user');
	  
	  $model = new Gps_customer();
      //$model->attributes=$params;
	  $model->LAT=$request->post('LAT');
	  $model->LAG=$request->post('LAG');
	  $model->RADIUS=$request->post('RADIUS');
	  $model->CREATED_AT=$request->post('CREATED_BY');
	  $model->CUST_ID=$request->post('CUST_ID');
	  //$model->save();
 
     /*   if ($model->save()) {
		   return "gps: {'status':1}";
	   } */
	//}
 /*
      $this->setHeader(200);
      echo json_encode(array('data'=>array_filter($model->attributes)),JSON_PRETTY_PRINT);
 
      } 
      else
      {
      $this->setHeader(400);
      echo json_encode(array('error_code'=>400,'errors'=>$model->errors),JSON_PRETTY_PRINT);
      } */
 

	
	/* public function actionUpdate($id)
    {
        if (! Yii::$app->request->isPut) {
            throw new MethodNotAllowedHttpException('Please use PUT');
        }

    
        $position = Gps_customer::findOne($id);

        if (Yii::$app->request->post() !== null) {
            $user->setPassword(Yii::$app->request->post('password'));
        }

        return $position->save();
    } */

	
}


