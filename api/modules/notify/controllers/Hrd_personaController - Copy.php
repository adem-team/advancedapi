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
use api\modules\notify\models\Hrd_persona;
use api\modules\notify\models\DeptSearch;
use yii\web\HttpException;
//use yii\data\ActiveDataProvider;
/**
 * Hrd_persona Controller API
 *
 * @author -ptr.nov-
 */
class Hrd_personaController extends ActiveController
{
    public $modelClass = 'api\modules\notify\models\Dept';
	public $serializer = [
		'class' => 'yii\rest\Serializer',
	//	'collectionEnvelope' => 'Personalia',
	];
	  
    public function behaviors()    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                 // ['class' => HttpBearerAuth::className()],
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
	
	public function actions()
	 {
		 $actions = parent::actions();
		unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		 //unset($actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		 return $actions;
	 }
	
	protected function test() 
	{
	
		//$array = array();
		$crt='';
		//$array['cols'][] = array('type' => 'string');
		//$array['cols'][] = array('type' => 'number');

		//HERE you have the difference
		$crt_pie='{
			  "cols": [
			        {"id":"","label":"Topping","pattern":"","type":"string"},
			        {"id":"","label":"Slices","pattern":"","type":"number"}
			      ],
			  "rows": [
			        {"c":[{"v":"Piter","f":null},{"v":3,"f":null}]},
			        {"c":[{"v":"EKA","f":null},{"v":1,"f":null}]},
			        {"c":[{"v":"Devan","f":null},{"v":1,"f":null}]},
			        {"c":[{"v":"Soni","f":null},{"v":1,"f":null}]},
			        {"c":[{"v":"Udin","f":null},{"v":2,"f":null}]}
			      ]
			}';
	$crt_pie1='{
			  "cols": [
			        {"id":"","label":"Topping","pattern":"","type":"string"},
			        {"id":"","label":"Slices","pattern":"","type":"string"}
			      ],
			  "rows": [
			        {"c":[{"v":"Piter","f":null},{"v":"1","f":null}]},
			        {"c":[{"v":"EKA","f":"A"},{"v":"1","f":null}]},
			        {"c":[{"v":"Devan","f":null},{"v":"A","f":null}]},
			        {"c":[{"v":"Soni","f":null},{"v":"1","f":null}]},
			        {"c":[{"v":"Udin","f":null},{"v":"1","f":1}]}
			      ],
				   "oklah":'.$this->getCategsub().'
			  
			}';
			
	 //$crt_pie1=$this->getCategsub();
	 //print_r($this->getCategsub());
			
		$crt_org='[
						   {							
							  "Name":"Piter",
							  "Manager":"www"							  
						   },
						   {
							   "Name":"Eka",
							  "Manager":"aaaa"
						   },
						   {
							  " Name":"Soni",
							  "Manager":"ssss"
						   },
						   {
							   "Name":"Devan",
							  "Manager":"asd"
						   },
						   {
							   "Name":"Tano",
							  "Manager":"asd"
						   }
						]';

		//return json_encode($array);
		return  Json::decode($crt_pie1);
	}
	
	protected function getCategsub()
	{
		 $modelClass = $this->modelClass;
         $query = $modelClass::find();
		 $ctg= new ActiveDataProvider([
             'query' => $query			 
         ]);
		 return Json::encode($ctg->getModels());
	}
	
	public function actionIndex()
     {
		/*
		$searchModel = new DeptSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
         $modelClass = $this->modelClass;
         $query = $modelClass::find();
         $x1= new ActiveDataProvider([
             'query' => $query
         ]);
		 $query = DeptSearch::find();
		 $x2= '"chart": {
                "caption": "LukisonGroup Pilot Project",
                "subcaption": "Planned vs Actual",                
                "dateformat": "dd/mm/yyyy",
                "outputdateformat": "ddds mns yy",
                "ganttwidthpercent": "70",
                "ganttPaneDuration": "50",
                "ganttPaneDurationUnit": "d",
                "plottooltext": "$processName{br} $label starting date $start{br}$label ending date $end",
                "theme": "fint"
            }';
		//return ArrayHelper::merge($x1,$x2);
		//$x=array(json($x1),$x2);
		print_r($x1->deptsub);
		return $x1;
		*/
		return $this->test();
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


