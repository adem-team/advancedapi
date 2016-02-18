<?php

namespace api\modules\sss\controllers;

use yii;
use yii\helpers\ArrayHelper;
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
use api\modules\sss\models\Chart;
use yii\web\HttpException;
//use yii\data\ActiveDataProvider;
/**
 * Hrd_persona Controller API
 *
 * @author -ptr.nov-
 */
class ChartController extends ActiveController
{
    public $modelClass = 'api\modules\sss\models\Chart';
	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'chartsss',
		//'collectionEnvelope' => 'Personalia',
	];
    public function behaviors()    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'authMethods' => [
               //  ['class' => HttpBearerAuth::className()],
                // ['class' => QueryParamAuth::className()],//, 'tokenParam' => 'access-token'],
                ]
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
                'Origin' => ['http://ptrnov-erp.dev', 'https://ptrnov-erp.dev'],
                'Access-Control-Request-Method' => ['POST', 'PUT'],
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
	
	//public function actions()
	// {
	//	 $actions = parent::actions();
		//unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		 //unset($actions['update'], $actions['create'], $actions['delete'], $actions['view']);
	//	 return $actions;
	// }
	/*
	public function actions()
    {
        $actions = parent::actions();

        unset($actions['view']);

        return $actions;
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
         
		return  $model;
    }
	
	*/
	
	protected function test() 
	{
	
		//$array = array();
	
		$ftgraph='[
					  {							
						  "id":1,
						  "Val_Nm":"Total_Member",							  
						  "Val_1":1407,							  
						  "UPDT":"2015-04-16",							  
						  "Val_Json":""			  
					   },
					   {							
						  "id":2,
						  "Val_Nm":"Total_ Card",							  
						  "Val_1":4251,							  
						  "UPDT":"2015-04-09",							  
						  "Val_Json":""			  
					   },
					    {							
						  "id":3,
						  "Val_Nm":"Top5_Member",							  
						  "Val_1":null,							  
						  "UPDT":"2015-04-09",							  
						  "Val_Json":{[
								  		{"c":[{ "country": "DAVIN VARANDI", "total": "6,304,500" }]},
								  		{"c":[{ "country": "Agus Diyanto", "total": "6,416,600" }]},
								  		{"c":[{ "country": "Imelda Jeni", "total": "6,687,300" }]},
								  		{"c":[{"country": "Darmawi", "total": "6,793,400" }]},
								  		{"c":[{"country": "JM. Dewiyani", "total": "10,880,800"}]}
						  			]}
						  			
					  
					]';

		//return json_encode($array);
		return  json_decode($ftgraph);
	}

	//public function actionIndex()
     //{
		/*
         $modelClass = $this->modelClass;
         $query = $modelClass::find();
         return new ActiveDataProvider([
             'query' => $query
         ]);
		 */
 		//$model = $this->findModel(12);
 		//$Val_Json = ArrayHelper::map(Chart::find()->orderBy('Id')->asArray()->all(), 'Id','Val_Json');
 		//$a=str_replace('"',"",$model);
 		//$a=str_replace('/ \','', $Val_Json);
 		//$a=json_decode_nice($Val_Json, $assoc = true);
 		//$a=$model->Id;
 		//$b=$model->Val_Nm;
 		//$c=$model->Val_1;
 		//$d=$model->UPDT;
		//$e=str_replace('"',"'",$model->Val_Json);

		///$x=substr_replace('"', '', $model->Val_Json);
		//$b=ArrayHelper::remove($model,'Val_Json');
		//$a=ArrayHelper::toArray(substr_replace('"', '', $model->Val_Json),'Val_Json');
		

		//return $this->test();//json_decode($model);
    	//return $model;//json_decode($model);
     //}
	
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
	protected function findModel($id)
    {
        if (($model = Chart::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
   	 }

    protected function json_clean_decode($json, $assoc = false, $depth = 512, $options = 0) {
    // search and remove comments like /* */ and //
	    $json = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '', $json);
	   
	    if(version_compare(phpversion(), '5.4.0', '>=')) {
	        $json = json_decode($json, $assoc, $depth, $options);
	    }
	    elseif(version_compare(phpversion(), '5.3.0', '>=')) {
	        $json = json_decode($json, $assoc, $depth);
	    }
	    else {
	        $json = json_decode($json, $assoc);
	    }

	    return $json;
	}

	protected function json_decode_nice($json, $assoc = TRUE){
    $json = str_replace(array("\n","\r"),"\\n",$json);
    $json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":',$json);
    $json = preg_replace('/(,)\s*}$/','}',$json);
    return json_decode($json,$assoc);
}
}


