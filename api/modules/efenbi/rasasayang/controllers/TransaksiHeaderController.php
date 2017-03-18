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

use api\modules\efenbi\rasasayang\models\TransaksiHeader;
use api\modules\efenbi\rasasayang\models\TransaksiHeaderSearch;

/**
 * TransaksiHeaderController implements the CRUD actions for TransaksiHeader model.
 */
class TransaksiHeaderController extends ActiveController
{
    /**
      * Source Database declaration 
     */
    public $modelClass = 'api\modules\efenbi\rasasayang\models\TransaksiHeaderSearch';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'TransaksiHeader',
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
                    
                    $param=["TransaksiHeaderSearch"=>Yii::$app->request->queryParams];
                    //return $param;
                    $searchModel = new TransaksiHeaderSearch();
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
		
		$params    = Yii::$app->request->post();  
		/* foreach($params as $key => $val){
			$model      = new Transaksi(); 
			$model->attributes=$val;
			//$model->TRANS_ID =$code;
			$model->save();
		} */
		//$code='';
		//$rsltMsg="no-Action";
		if($params!=''){
			if($params['TRANS_TYPE']!=4 & $params['OUTLET_ID']!=''){ 
					//POST BOOKING=1|BUY=2|RECEVED=3
					$code=$params['TRANS_TYPE'].".".$params['OUTLET_ID'].".".str_replace("-","",date("Y-m-d"));
					//Delete All
					$cntHeader = TransaksiHeader::find()->where(['TRANS_ID'=>$code])->count();
					if($cntHeader==0){		
							//foreach($params as $key => $val){
								$model      = new TransaksiHeader(); 
								//$model->attributes=$val;
								$model->TRANS_ID =$code;
								$model->TRANS_TYPE =$params['TRANS_TYPE'];
								$model->TRANS_DATE =date("Y-m-d");
								$model->OUTLET_ID =$params['OUTLET_ID'];
								$model->CREATE_AT =date("Y-m-d H:i:s");
								$model->CREATE_BY ="AUTO GENERATE";
								if($model->save()){									
									$rsltMsg=["handling"=>"successful","TRANS_ID"=>$code];
								};	
							//}											
					}else{
						$rsltMsg=["handling"=>"exist"];				
					}
									
			}else{
				//POST Data SELL=4.
				 $rsltMsg="uncover";
			}
		} 
		return $rsltMsg; 
		//return $cntHeader; 
		//return $params;
	}	
}
