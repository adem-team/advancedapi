<?php

namespace api\modules\efenbi\rasasayang\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\helpers\ArrayHelper;

use api\modules\efenbi\rasasayang\models\TransaksiClosing;
use api\modules\efenbi\rasasayang\models\TransaksiClosingSearch;

/**
 * TransaksiClosingController implements the CRUD actions for TransaksiClosing model.
 */
class TransaksiClosingController extends ActiveController
{
    /**
      * Source Database declaration 
     */
    public $modelClass = 'api\modules\efenbi\rasasayang\models\TransaksiClosingSearch';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'TransaksiClosing',
    ]; 
    
    /**
     * @inheritdoc
     */
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
    
    public function actions()
    {       
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => function () {
                    
                    $param=["TransaksiClosingSearch"=>Yii::$app->request->queryParams];
                    //return $param;
                    $searchModel = new TransaksiClosingSearch();
                    return $searchModel->search($param);
                },
            ],
        ];
    } 

	public function actionCreate()
    {
        //README -ptr.nov-
		//Header Form 	: 	Content-Type application/json
		//get request	:	Yii::$app->request->post();   
		//return $params;
		//return $params[0];
		//return $params[0]['name'];
		//order json object...
		//return $params['data'];
		//=====================================================
       	//$model      = new Transaksi();
		
		//$params    = Yii::$app->request->post();
		$params     = $_REQUEST;        
       	
		if($params!=''){
			$model      = new TransaksiClosing(); 
			$model->attributes=$params;	
			// $model->STATUS =$params['STATUS'];
			// $model->TRANS_DATE =$params['TRANS_DATE'];//date("Y-m-d");
			// $model->OUTLET_ID =$params['OUTLET_ID'];
			// $model->ITEM_BARCODE =$params['ITEM_BARCODE'];
			// $model->BUY =$params['BUY'];
			// $model->RCVD =$params['RCVD'];
			// $model->SELL =$params['SELL'];
			// $model->SISA =$params['SISA'];
			// $model->IMG64 =$params['IMG64'];
			$model->CREATE_AT =date("Y-m-d H:i:s");
			$model->CREATE_BY ="CLOSING";			
			if($model->save()){									
				$rsltMsg=["handling"=>"successful"];
			}else{
				$rsltMsg=["handling"=>"Failed"];
			};							
		} 
		return $rsltMsg;
	}	
}
